<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Авторизация </title>
  <link rel="stylesheet" href="css/signUpstyle.css">
  <link rel="stylesheet" href="css/signUpstyle.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #094B4B;
      width: 90%;
      max-width: 400px;
      margin: 15% auto;
      border-radius: 12px;
      padding: 16px 22px 17px 20px;
      display: flex;
      align-items: center;
    }

    .modal-content p {
      color: #fff;
      font-family: Verdana;
      margin-left: 10px;
    }

    .icon__wrapper {
      height: 34px;
      width: 34px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.253);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon__wrapper span {
      font-size: 21px;
      color: #fff;
    }

    .close {
      margin-left: 5px;
      margin-right: 5px;
      color: #fff;
      transition: transform 0.5s;
      font-size: 18px;
      cursor: pointer;
    }

    .close:hover {
      transform: scale(1.3);
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="images/dgtu.jpg" alt="">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Авторизация</div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="email" placeholder="Введите адрес электронной почты" required value="<?php if (isset($email)) echo $email; ?>" title="<?php if (isset($emailError)) echo $emailError; ?>">
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Введите пароль" required title="<?php if (isset($passwordError)) echo $passwordError; ?>">
              </div>
              <div class="text"><a href="#">Забыли пароль?</a></div>
              <div class="button input-box">
                <input type="submit" value="Войти">
              </div>
              <div class="text sign-up-text" style=" text-align: center;">У вас нет аккаунта? <a href="registr.php">Зарегистрироваться</a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="emailErrorModal" class="modal">
    <div class="modal-content">
      <div class="icon__wrapper">
        <span class="close">×</span>
      </div>
      <p>Ошибка: Пользователь с такой почтой не найден</p>
    </div>
  </div>
  <div id="passwordErrorModal" class="modal">
    <div class="modal-content">
      <div class="icon__wrapper">
        <span class="close">×</span>
      </div>
      <p>Ошибка: Неверный пароль</p>
    </div>
  </div>
  <?php
  session_start();
  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      if (password_verify($password, $row['password'])) {
        // После успешной авторизации
        if ($row['role'] == 1) {
          $_SESSION['user_id'] = $row['id'];
          header("Location: adminpanel.php");
          exit();
        } else {
          $_SESSION['user_id'] = $row['id'];
          // Обновляем last_activity_time для текущего пользователя
          $userId = $row['id'];
          $updateSql = "UPDATE users SET last_activity_time = CURRENT_TIMESTAMP WHERE id = $userId";
          $conn->query($updateSql);
          header("Location: index.php");
          $isLoggedIn = true;
          exit();
        }
      } else {
        echo "<script>document.getElementById('passwordErrorModal').style.display = 'block';</script>";
      }
    } else {
      echo "<script>document.getElementById('emailErrorModal').style.display = 'block';</script>";
    }
  }
  $conn->close();
  ?>
  <script>
    function closeModal(modalId) {
      var modal = document.getElementById(modalId);
      modal.style.display = "none";
    }
    document.querySelector("#emailErrorModal .close").addEventListener("click", function() {
      closeModal("emailErrorModal");
    });
    document.querySelector("#passwordErrorModal .close").addEventListener("click", function() {
      closeModal("passwordErrorModal");
    });
  </script>
</body>

</html>