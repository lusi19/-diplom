<?php
// Начинаем сеанс, если не было начато ранее
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root"; // Замените на свои данные
$password = "gonedone24@L";
$dbname = "diplom"; // Замените на свои данные

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем ID пользователя из сессии (предполагается, что он хранится там)
$user_id = $_SESSION['user_id']; // Замените 'user_id' на ключ, под которым хранится ID пользователя в сессии

// Обновляем статус пользователя на "Офлайн" в базе данных
$sql = "UPDATE users SET last_activity_time = NOW() WHERE id = $user_id"; // Предполагается, что у вас есть столбец `last_activity_time` для хранения времени последней активности пользователя
$result = $conn->query($sql);

// Удаляем все переменные сеанса
session_unset();

// Уничтожаем сеанс
session_destroy();

// Перенаправляем пользователя на страницу входа или на другую нужную страницу
header("Location: index.php");
exit;
?>
