<?php
session_start();

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "gonedone24@L";
$dbname = "diplom";

// Создаем соединение с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем идентификатор мероприятия для удаления, если он передан
if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Ваш SQL-запрос для удаления записи об участии по идентификатору мероприятия и текущего пользователя
    $delete_sql = "DELETE FROM event_participants WHERE event_id = '$eventId' AND user_id = '{$_SESSION['user_id']}'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "Запись успешно удалена";
    } else {
        echo "Ошибка при удалении записи: " . $conn->error;
    }
}

// SQL-запрос для выборки всех мероприятий пользователя
$user_id = $_SESSION['user_id'];
$select_sql = "SELECT * FROM event_participants WHERE user_id = '$user_id'";

$result = $conn->query($select_sql);

if ($result->num_rows > 0) {
    // Создаем массив для хранения всех мероприятий пользователя
    $events = array();

    // Добавляем каждое мероприятие в массив
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    // Выводим данные о мероприятиях пользователя в формате JSON
    json_encode($events);
} else {
    // Если мероприятий нет, выводим пустой массив
    json_encode(array());
}

$conn->close();
?>
