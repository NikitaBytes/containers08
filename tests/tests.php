<?php

require_once __DIR__ . '/testframework.php';
$config = require __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$testFramework = new TestFramework();

// 🔹 Тест 1: Проверка подключения к базе данных
$testFramework->add('Database connection', function() use ($config) {
    try {
        $db = new Database($config["db"]["path"]);
        return assertExpression(true, "Database connected successfully");
    } catch (Exception $e) {
        return assertExpression(false, "Database connection failed: " . $e->getMessage());
    }
});

// 🔹 Тест 2: Проверка количества записей
$testFramework->add('Table count', function() use ($config) {
    $db = new Database($config["db"]["path"]);
    $count = $db->Count("page");
    return assertExpression($count > 0, "Page table contains records", "Page table is empty");
});

// 🔹 Тест 3: Проверка метода Create
$testFramework->add('Create record', function() use ($config) {
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "Test Page", "content" => "Test Content"]);
    return assertExpression($id > 0, "Record created successfully", "Failed to create record");
});

// 🔹 Тест 4: Проверка метода Read
$testFramework->add('Read record', function() use ($config) {
    $db = new Database($config["db"]["path"]);
    $record = $db->Read("page", 1);
    return assertExpression(!empty($record), "Record read successfully", "Failed to read record");
});

// 🔹 Тест 5: Проверка метода Update
$testFramework->add('Update record', function() use ($config) {
    $db = new Database($config["db"]["path"]);
    $result = $db->Update("page", 1, ["title" => "Updated Title"]);
    return assertExpression($result, "Record updated successfully", "Failed to update record");
});

// 🔹 Тест 6: Проверка метода Delete
$testFramework->add('Delete record', function() use ($config) {
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "To Delete", "content" => "Delete this"]);
    $result = $db->Delete("page", $id);
    return assertExpression($result, "Record deleted successfully", "Failed to delete record");
});

// Запуск тестов
$testFramework->run();
echo $testFramework->getResult();