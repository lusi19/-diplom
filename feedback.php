<?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = "gonedone24@L";
$dbname = "diplom"; // Имя вашей базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
  die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка, были ли данные отправлены методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Получение данных из формы
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Подготовка SQL-запроса
  $sql = "INSERT INTO feedback (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  // Выполнение запроса
  if ($conn->query($sql) === TRUE) {
    echo "Сообщение успешно отправлено!";
  } else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
  }
}

// Закрытие подключения
$conn->close();
?>
