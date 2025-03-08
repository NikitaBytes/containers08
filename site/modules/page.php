<?php

/**
 * Класс Page для работы с шаблонами страниц.
 */
class Page {
    private $template;

    /**
     * Конструктор принимает путь к файлу шаблона.
     */
    public function __construct($template) {
        if (!file_exists($template)) {
            die("Файл шаблона не найден: " . $template);
        }
        // Загружаем содержимое шаблона в переменную
        $this->template = file_get_contents($template);
    }

    /**
     * Метод Render подставляет данные из массива $data в шаблон и возвращает итоговый HTML.
     */
    public function Render($data) {
        $output = $this->template;
        // Проходим по каждому ключу массива данных и заменяем соответствующий плейсхолдер
        foreach ($data as $key => $value) {
            $placeholder = "{{" . strtoupper($key) . "}}";
            $output = str_replace($placeholder, $value, $output);
        }
        return $output;
    }
}