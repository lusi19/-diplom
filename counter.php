<?php
// Начало сессии
session_start();

// Получаем текущую дату
$current_date = date('Y-m-d');

// Создаем имя файла на основе текущей даты
$counter_file = 'total_visits_' . $current_date . '.txt';

// Проверяем, установлен ли счетчик для этой страницы
if (!isset($_SESSION['page_visits'])) {
    $_SESSION['page_visits'] = 1;
} else {
    $_SESSION['page_visits']++;
}

// Увеличиваем счетчик посещений для текущей страницы
if (file_exists($counter_file)) {
    $total_visits = (int)file_get_contents($counter_file);
    $total_visits++;
} else {
    $total_visits = 1;
}

// Сохраняем общее количество посещений для текущей даты
file_put_contents($counter_file, $total_visits);
?>
