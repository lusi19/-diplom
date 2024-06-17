<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title>Админ панель</title>
  <link rel="stylesheet" href="css/admin.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
  body {
    margin: 0;
  }

  .container {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    margin-left: 30%;
    max-width: 600px;
  }

  .container input[type="text"],
  .container textarea {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
  }

  .container button {
    background-color: #0A2558;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
  }

  .container button:hover {
    background-color: #081D45;
  }

  .container select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    box-sizing: border-box;
    background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.293 6.293a1 1 0 1 0-1.414 1.414L10 10.414l-2.879-2.88a1 1 0 1 0-1.414 1.414l3.5 3.5a1 1 0 0 0 1.414 0l3.5-3.5a1 1 0 1 0-1.414-1.414L10 10.414 14.293 6.293z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px top 50%;
    background-size: 20px auto;
  }

  .container select::-ms-expand {
    display: none;
  }

  .toggle-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    z-index: 9999;
    color: #fff;
    font-size: 30px;
  }

  .sidebar {
    position: fixed;
    height: 100%;
    width: 240px;
    background: #0A2558;
    transition: all 0.5s ease;
    margin-top: 0;
  }

  .sidebar.active {
    width: 60px;
  }

  .sidebar .nav-links {
    margin-top: 80px;
  }

  .sidebar .logo-details {
    display: none;
  }

  @media only screen and (max-width: 768px) {
    .container {
      max-width: 90%;
    }
  }

  @media only screen and (max-width: 480px) {
    .sidebar {
      width: 200px;
    }

    .sidebar.active {
      width: 100px;
    }
  }

  /* После вашего существующего CSS */
  .sidebar.active .nav-links li span {
    display: none;
  }

  .sidebar .nav-links li.active span {
    display: inline;
  }
</style>

<body>
  <div class="sidebar">
    <div class="toggle-btn" onclick="toggleSidebar()">
      <i class='bx bx-menu'></i>
    </div>
    <ul class="nav-links">
      <li>
        <a href="adminpanel.php" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Мероприятия</span>
        </a>
      </li>
      <li>
        <a href="send_letter.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">Рассылки</span>
        </a>
      </li>
      <li>
        <a href="static.php">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="links_name">Статистика</span>
        </a>
      </li>
      <li>
        <a href="users.php">
          <i class='bx bx-user'></i>
          <span class="links_name">Пользователи</span>
        </a>
      </li>
      <li>
        <a href="messenger.php">
          <i class='bx bx-message'></i>
          <span class="links_name">Сообщения</span>
        </a>
      </li>

      <li class="log_out">
        <a href="logout.php">
          <i class='bx bx-log-out'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>

    </ul>
  </div>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_EVENTS"])) {
    $newsTitle = $_POST["EVENTS_title"];
    $newsContent = $_POST["EVENTS_content"];
    $sql = "INSERT INTO EVENTS (title, content) VALUES ('$newsTitle', '$newsContent')";
    if ($conn->query($sql) === TRUE) {
      echo '<script>alert("Новость успешно добавлена");</script>';
    } else {
      echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_EVENTS"])) {
    $newsId = $_POST["EVENTS_id"];
    $newsTitle = $_POST["EVENTS_title"];
    $newsContent = $_POST["EVENTS_content"];
    $sql = "UPDATE EVENTS SET title='$newsTitle', content='$newsContent' WHERE id=$newsId";
    if ($conn->query($sql) === TRUE) {
      echo '<script>alert("Новость успешно отредактирована");</script>';
    } else {
      echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_EVENTS"])) {
    $newsId = $_POST["delete_EVENTS_id"];
    $sql = "DELETE FROM EVENTS WHERE id=$newsId";
    if ($conn->query($sql) === TRUE) {
      echo '<script>alert("Новость успешно удалена");</script>';
    } else {
      echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
  }
  $sql = "SELECT * FROM EVENTS";
  $result = $conn->query($sql);
  $newsList = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $newsList[] = $row;
    }
  }
  $conn->close();
  ?>
  <br>
  <br>
  
  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h3>Добавить мероприятие</h3>
      <input type="text" name="EVENTS_title" placeholder="Заголовок новости">
      <textarea name="EVENTS_content" placeholder="Содержание новости"></textarea>
      <button type="submit" name="add_EVENTS">Добавить</button>
    </form>
  </div>
  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h3>Редактировать мероприятие</h3>
      <select name="EVENTS_id">
        <option value="">Выберите мероприятие для редактирования</option>
        <?php foreach ($newsList as $news) : ?>
          <option value="<?php echo $news['id']; ?>"><?php echo $news['title']; ?></option>
        <?php endforeach; ?>
      </select>
      <input type="text" name="EVENTS_title" placeholder="Новый заголовок">
      <textarea name="EVENTS_content" placeholder="Новое содержание"></textarea>
      <button type="submit" name="edit_EVENTS">Сохранить изменения</button>
    </form>
  </div>
  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h3>Удалить мероприятие</h3>
      <select name="delete_EVENTS_id">
        <option value="">Выберите мероприятие для удаления</option>
        <?php foreach ($newsList as $news) : ?>
          <option value="<?php echo $news['id']; ?>"><?php echo $news['title']; ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" name="delete_EVENTS">Удалить</button>
    </form>
  </div>
  <div class="container">
    <h3>Список новостей</h3>
    <ul>
      <?php foreach ($newsList as $news) : ?>
        <li><?php echo $news['title']; ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</body>

</html>
</div>
<script>
  function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const sidebarBtn = document.querySelector(".toggle-btn");
    sidebar.classList.toggle("active");
    if (sidebar.classList.contains("active")) {
      sidebarBtn.innerHTML = '<i class="bx bx-menu-alt-right"></i>';
    } else {
      sidebarBtn.innerHTML = '<i class="bx bx-menu"></i>';
    }
  }
</script>
</body>

</html>