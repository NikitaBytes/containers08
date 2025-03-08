<?php

// Подключаем файлы с классами и конфигурацию
require_once __DIR__ . '/modules/database.php';
require_once __DIR__ . '/modules/page.php';
$config = require __DIR__ . '/config.php';
if (!isset($config['db']['path'])) {
    die("Ошибка: файл config.php не содержит путь к базе данных.");
}
// Создаем объект для работы с базой данных, используя путь из конфига
$db = new Database($config["db"]["path"]);

// Создаем объект страницы, указывая путь к шаблону
$page = new Page(__DIR__ . '/templates/index.tpl');

// Получаем id страницы из GET-параметра; по умолчанию используется страница с id = 1
$pageId = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Читаем данные страницы из таблицы "page"
$data = $db->Read("page", $pageId);

// Выводим отрендеренную страницу
echo $page->Render($data);