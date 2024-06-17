<?php
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "gonedone24@L";
$dbname = "diplom";
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения с базой данных
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Запрос на получение всех факультетов из базы данных
$sql = "SELECT * FROM faculties_info";
$result = $conn->query($sql);

$faculties = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $faculties[] = array(
      'id' => $row['id'],
      'name' => $row['name'],
      'category' => $row['category'],
      'description' => $row['description'],
      'dean_name' => $row['dean_name'],
      'dean_image' => $row['dean_image'],
      'image' => $row['image']
    );
  }
}

echo json_encode(array('faculties' => $faculties));
$conn->close();
?>
