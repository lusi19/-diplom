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

$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];

// Получаем текущий хэш пароля пользователя из базы данных
$user_id = $_SESSION['user_id']; // Используем сессию для получения ID пользователя
$stmt = $conn->prepare('SELECT password FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentHashedPassword = $row['password'];

    // Проверяем, совпадает ли старый пароль с текущим паролем
    if (!password_verify($oldPassword, $currentHashedPassword)) {
        echo json_encode(['success' => false, 'error' => 'invalid_old_password']);
        exit;
    }

    // Проверяем, не совпадает ли новый пароль с текущим паролем
    if (password_verify($newPassword, $currentHashedPassword)) {
        echo json_encode(['success' => false, 'error' => 'same_as_old_password']);
        exit;
    }

    // Хэшируем новый пароль и обновляем его в базе данных
    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->bind_param('si', $newPasswordHash, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'update_failed']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'user_not_found']);
}

$conn->close();
?>
