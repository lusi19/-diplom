<?php
// Подключение к базе данных (замените данными вашего сервера)
$servername = "localhost";
$username = "root";
$password = "gonedone24@L";

$dbname = "diplom";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];

  // Подготовка и выполнение запроса на вставку данных в базу
  $sql = "INSERT INTO subscribe (email) VALUES ('$email')";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Закрытие подключения к базе данных
$conn->close();
?>
