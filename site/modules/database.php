<?php

/**
 * Класс Database для работы с SQLite базой данных.
 */
class Database {
    private $pdo;

    /**
     * Конструктор принимает путь к файлу базы данных.
     */
    public function __construct($path) {
        try {
            // Устанавливаем соединение с базой данных SQLite через PDO
            $this->pdo = new PDO("sqlite:" . $path);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }

    /**
     * Выполняет SQL запрос без возврата результата.
     */
    public function Execute($sql) {
        try {
            return $this->pdo->exec($sql);
        } catch (PDOException $e) {
            die("Ошибка выполнения SQL запроса: " . $e->getMessage());
        }
    }

    /**
     * Выполняет SQL запрос и возвращает результат как ассоциативный массив.
     */
    public function Fetch($sql) {
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Ошибка выборки данных: " . $e->getMessage());
        }
    }

    /**
     * Создает запись в таблице и возвращает идентификатор созданной записи.
     */
    public function Create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Ошибка создания записи: " . $e->getMessage());
        }
    }

    /**
     * Возвращает запись из таблицы по id.
     */
    public function Read($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->execute(["id" => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Ошибка чтения записи: " . $e->getMessage());
        }
    }

    /**
     * Обновляет запись в таблице по id.
     */
    public function Update($table, $id, $data) {
        $setClause = implode(", ", array_map(function($key) {
            return "$key = :$key";
        }, array_keys($data)));
        $sql = "UPDATE $table SET $setClause WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        try {
            $data["id"] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            die("Ошибка обновления записи: " . $e->getMessage());
        }
    }

    /**
     * Удаляет запись из таблицы по id.
     */
    public function Delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        try {
            return $stmt->execute(["id" => $id]);
        } catch (PDOException $e) {
            die("Ошибка удаления записи: " . $e->getMessage());
        }
    }

    /**
     * Возвращает количество записей в таблице.
     */
    public function Count($table) {
        $sql = "SELECT COUNT(*) as count FROM $table";
        $stmt = $this->pdo->query($sql);
        try {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["count"];
        } catch (PDOException $e) {
            die("Ошибка подсчета записей: " . $e->getMessage());
        }
    }
}