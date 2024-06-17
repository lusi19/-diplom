<?php
session_start();

function updateUserProfile($firstName, $lastName, $email, $username, $imagePath, $userId, $conn)
{
  $sql = "UPDATE users SET first_name='$firstName', last_name='$lastName', email='$email', username='$username'";
  if (!empty($imagePath)) {
    $sql .= ", images='$imagePath'";
  }
  $sql .= " WHERE id=$userId";
  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    echo "Ошибка при обновлении профиля: " . $conn->error;
    return false;
  }
}

function uploadImage($file)
{
  $targetDir = "uploads/";
  $targetFile = $targetDir . basename($file["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  $check = getimagesize($file["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "Файл не является изображением.";
    $uploadOk = 0;
  }

  if ($file["size"] > 500000) {
    echo "Файл слишком большой.";
    $uploadOk = 0;
  }

  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Только JPG, JPEG, PNG и GIF файлы разрешены.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "Файл не был загружен.";
    return "";
  } else {
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
      return $targetFile;
    } else {
      echo "Произошла ошибка при загрузке файла.";
      return "";
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])) {
  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $user_id = $_SESSION['user_id'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $imagePath = "";

  if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {
    $imagePath = uploadImage($_FILES["image"]);
  }

  updateUserProfile($firstName, $lastName, $email, $username, $imagePath, $user_id, $conn);
  $conn->close();
}

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT first_name, last_name, username, email, images FROM users WHERE id = $user_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $username = $row['username'];
    $email = $row['email'];
    $image = $row['images'];
  } else {
    echo "Пользователь не найден.";
  }

  $conn->close();
}

if (isset($_SESSION['user_id'])) {
  $buttonText = 'Выйти';
  $buttonLink = 'logout.php';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contactType']) && isset($_POST['contactValue'])) {
  if (isset($_POST['agree']) && $_POST['agree'] == 'agree') {
    $contactType = $_POST['contactType'];
    $contactValue = $_POST['contactValue'];

    $servername = "localhost";
    $username = "root";
    $password = "gonedone24@L";
    $dbname = "diplom";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id'];
    $sql = "INSERT INTO dop_info_users (user_id, contact_type, contact_value) VALUES ($userId, '$contactType', '$contactValue')";

    if ($conn->query($sql) === TRUE) {
      
    } else {
      echo "Ошибка при добавлении контакта: " . $conn->error;
    }
    $conn->close();
  } else {
    echo "Вы должны дать согласие на обработку персональных данных.";
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteContact']) && isset($_POST['contactType']) && isset($_POST['contactValue'])) {
  $contactType = $_POST['contactType'];
  $contactValue = $_POST['contactValue'];

  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $userId = $_SESSION['user_id'];
  $sql = "DELETE FROM dop_info_users WHERE user_id = $userId AND contact_type = '$contactType' AND contact_value = '$contactValue'";

  if ($conn->query($sql) === TRUE) {
    echo "Контакт успешно удален.";
  } else {
    echo "Ошибка при удалении контакта: " . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Личный кабинет</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="css/profile.css" rel="stylesheet">

  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Стиль для кнопки выбора файла */
    #exampleInputFile[disabled] {
      pointer-events: none;
      /* Запрещаем события мыши */
      opacity: 0.5;
      /* Уменьшаем прозрачность кнопки */
    }
  </style>
</head>

<body>
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="images/dgtu-logo.png">
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="profile.php" class="active">Профиль</a></li>
          <li><a href="ball_kal.php">Профоринтационный тест</a></li>
          <a href="<?php echo $buttonLink; ?>" class="btn-getstarted"><?php echo $buttonText; ?></a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <div class="container">
    <div class="col-md-12">
      <br>
      <br>
      <div class="col-md-4">
        <div class="portlet light profile-sidebar-portlet bordered">
          <div class="profile-userpic">
            <img id="profileImage" src="<?php echo isset($image) ? $image : 'https://bootdey.com/img/Content/avatar/avatar6.png'; ?>" class="img-responsive" alt>
          </div>
          <div class="profile-usertitle">
            <div class="profile-usertitle-name"><?php echo $first_name . " " . $last_name; ?></div>
            <div class="profile-usertitle-job"><?php echo $username; ?></div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <div>

              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Личные данные</a></li>
                <li role="presentation"><a href="#dop_info" aria-controls="profile" role="tab" data-toggle="tab">Доп.контакты</a></li>
                <li role="presentation"><a href="#password_change" aria-controls="messages" role="tab" data-toggle="tab">Смена пароля</a></li>
                <li role="presentation"><a href="#my_merop" aria-controls="settings" role="tab" data-toggle="tab">Мероприятия</a></li>
              </ul>

              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                  <form id="profileForm" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="form-group">
                      <label for="inputName">Имя</label>
                      <input type="text" class="form-control" id="inputName" name="first_name" placeholder="Name" value="<?php echo isset($first_name) ? $first_name : ''; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="inputLastName">Фамилия</label>
                      <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="Last Name" value="<?php echo isset($last_name) ? $last_name : ''; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="inputUsername">Никнейм</label>
                      <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" value="<?php echo isset($username) ? $username : ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Адрес электронной почты</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>" readonly>
                    </div>

                    <div class="form-group" id="imageGroup">
                      <label for="exampleInputFile">Выберите фото</label>
                      <input type="file" id="exampleInputFile" name="image" class="form-control disabled-file-input" disabled>
                      <p class="help-block">Всем будет проще узнать вас, если вы загрузите свою настоящую фотографию. Вы можете загрузить изображение в формате JPG или PNG..</p>
                    </div>
                    <button type="button" class="btn btn-default" id="editButton">Редактировать</button>
                    <button type="submit" class="btn btn-default" id="saveButton" style="display: none;">Сохранить изменения</button>
                  </form>
                </div>
                <br>
                <div role="tabpanel" class="tab-pane" id="dop_info">
                  <div class="row">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                      <h4>Дополнительные контакты</h4>
                      <button class="btn btn-primary btn-sm" id="addContactButton" data-toggle="modal" data-target="#addContactModal">Добавить</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Тип контакта</th>
                            <th>Контакт</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="additionalContacts">
                          <?php echo isset($contactHtml) ? $contactHtml : ''; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- Модальное окно для добавления контакта -->
                <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                          <h5 class="modal-title" id="addContactModalLabel">Добавить контакт</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      </div>
                      <div class="modal-body">
                        <!-- Форма для добавления контакта -->
                        <form id="addContactForm" method="POST">
                          <div class="form-group">
                            <label for="contactType">Тип контакта</label>
                            <select class="form-control" id="contactType" name="contactType">
                              <option value="">Выберите тип контакта</option>
                              <option value="Почта">Электронная почта</option>
                              <option value="Телефон">Телефон</option>
                              <option value="Вконтакте">Вконтакте</option>
                              <option value="Телеграм">Телеграм</option>
                            </select>
                            <span class="error-message" id="contactTypeError" style="color: red;"></span>
                          </div>
                          <div class="form-group">
                            <label for="contactValue">Контакт</label>
                            <input type="text" class="form-control" id="contactValue" name="contactValue" placeholder="Введите контакт">
                            <span class="error-message" id="contactValueError" style="color: red;"></span>
                          </div>
                          <div class="form-group form-check" style="margin-top: 15px;">
                            <input type="checkbox" id="agree" name="agree" value="agree" />
                            <label for="agree">Я даю согласие на <a href="dataset\Документ Microsoft Word.pdf">обработку персональных данных</a></label>
                            <span class="error-message" id="dataAgreementError" style="color: red;"></span>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary" id="saveContactButton" disabled>Сохранить</button>
                          </div>
                        </form>

                        <script>
                          document.getElementById('addContactForm').addEventListener('submit', function(event) {
                            var checkbox = document.getElementById('agree');
                            var errorMessage = document.getElementById('dataAgreementError');

                            if (!checkbox.checked) {
                              event.preventDefault();
                              errorMessage.textContent = 'Вы должны дать согласие на обработку персональных данных.';
                            } else {
                              errorMessage.textContent = '';
                            }
                          });
                          // Check if the checkbox for data processing consent is checked
                          document.getElementById('agree').addEventListener('change', function() {
                            var saveContactButton = document.getElementById('saveContactButton');
                            if (this.checked) {
                              // Enable the "Save" button if consent is given
                              saveContactButton.removeAttribute('disabled');
                            } else {
                              // Disable the "Save" button if consent is not given
                              saveContactButton.setAttribute('disabled', 'disabled');
                            }
                          });
                        </script>
                      </div>
                    </div>
                  </div>
                </div>

                <br>
                <div role="tabpanel" class="tab-pane" id="password_change">
                  <div class="form-group">
                    <label for="oldPassword">Старый пароль</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="oldPassword" placeholder="Введите старый пароль">
                      <div class="input-group-append">
                        <span class="input-group-text eye-icon-container" onclick="togglePassword('oldPassword')">
                          <i class="eye-icon bx bx-show"></i>
                        </span>
                      </div>
                    </div>
                    <small id="oldPasswordError" class="error-message" style="color: red;"></small>
                  </div>
                  <div class="form-group">
                    <label for="newPassword">Новый пароль</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="newPassword" placeholder="Введите новый пароль">
                      <div class="input-group-append">
                        <span class="input-group-text eye-icon-container" onclick="togglePassword('newPassword')">
                          <i class="eye-icon bx bx-show"></i>
                        </span>
                      </div>
                    </div>
                    <small id="newPasswordError" class="error-message" style="color: red;"></small>
                  </div>
                  <div class="form-group">
                    <label for="confirmNewPassword">Подтвердите новый пароль</label>
                    <div class="input-group">
                      <input type="password" class="form-control" id="confirmNewPassword" placeholder="Подтвердите новый пароль">
                    </div>
                    <small id="confirmNewPasswordError" class="error-message" style="color: red;"></small>
                  </div>
                  <button type="button" class="btn btn-primary" id="savePasswordButton">Сохранить</button>
                </div>
                <div class="modal" id="successModal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('successModal')">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Пароль успешно изменен!</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="closeModal('successModal')">Закрыть</button>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                  document.getElementById('savePasswordButton').addEventListener('click', function() {
                    var oldPassword = document.getElementById('oldPassword').value;
                    var newPassword = document.getElementById('newPassword').value;
                    var confirmNewPassword = document.getElementById('confirmNewPassword').value;

                    document.getElementById('oldPasswordError').innerText = '';
                    document.getElementById('newPasswordError').innerText = '';
                    document.getElementById('confirmNewPasswordError').innerText = '';

                    if (!oldPassword) {
                      document.getElementById('oldPasswordError').innerText = 'Старый пароль не может быть пустым';
                      return;
                    }

                    if (!newPassword) {
                      document.getElementById('newPasswordError').innerText = 'Новый пароль не может быть пустым';
                      return;
                    }

                    if (!confirmNewPassword) {
                      document.getElementById('confirmNewPasswordError').innerText = 'Подтверждение пароля не может быть пустым';
                      return;
                    }

                    if (newPassword.length < 8) {
                      document.getElementById('newPasswordError').innerText = 'Новый пароль должен быть не менее 8 символов';
                      return;
                    }

                    if (newPassword === oldPassword) {
                      document.getElementById('newPasswordError').innerText = 'Новый пароль не должен совпадать с текущим паролем';
                      return;
                    }

                    if (newPassword !== confirmNewPassword) {
                      document.getElementById('confirmNewPasswordError').innerText = 'Пароли не совпадают';
                      return;
                    }
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'change_password.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                      if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                          // Открываем модальное окно с сообщением об успешном изменении пароля
                          $('#successModal').modal('show');
                        } else {
                          if (response.error === 'invalid_old_password') {
                            document.getElementById('oldPasswordError').innerText = 'Неверный старый пароль';
                          } else if (response.error === 'same_as_old_password') {
                            document.getElementById('newPasswordError').innerText = 'Новый пароль не должен совпадать с текущим паролем';
                          } else {
                            alert('Ошибка при изменении пароля');
                          }
                        }
                      }
                    };
                    xhr.send('oldPassword=' + encodeURIComponent(oldPassword) + '&newPassword=' + encodeURIComponent(newPassword));
                  });

                  function togglePassword(inputId) {
                    var passwordInput = document.getElementById(inputId);
                    var eyeIcon = passwordInput.parentElement.querySelector(".eye-icon");

                    if (passwordInput.type === "password") {
                      passwordInput.type = "text";
                      eyeIcon.classList.remove("bx-show");
                      eyeIcon.classList.add("bx-hide");
                    } else {
                      passwordInput.type = "password";
                      eyeIcon.classList.remove("bx-hide");
                      eyeIcon.classList.add("bx-show");
                    }
                  }
                  // Функция для закрытия модального окна по его ID
                  function closeModal(modalId) {
                    $('#' + modalId).modal('hide');
                  }
                </script>
                <div role="tabpanel" class="tab-pane" id="my_merop">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Название мероприятия</th>
                        <th>Действие</th>
                      </tr>
                    </thead>
                    <tbody id="myEventsTable">
                      <?php
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

                      // SQL-запрос для выборки всех мероприятий пользователя
                      $user_id = $_SESSION['user_id'];
                      $select_sql = "SELECT events.id, events.title
               FROM events
               INNER JOIN event_participants ON events.id = event_participants.event_id
               WHERE event_participants.user_id = '$user_id'";

                      $result = $conn->query($select_sql);

                      if ($result->num_rows > 0) {
                        // Выводим каждое мероприятие
                        while ($row = $result->fetch_assoc()) {
                          echo '<tr>';
                          echo '<td>' . $row['id'] . '</td>';
                          echo '<td>' . $row['title'] . '</td>';
                          echo '<td><button class="btn btn-danger deleteEventButton" data-event-id="' . $row['id'] . '">Удалить</button></td>';
                          echo '</tr>';
                        }
                      } else {
                        echo '<tr><td colspan="3">Нет мероприятий</td></tr>';
                      }

                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>

                <div class="modal" id="confirmDeleteModal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">

                          <h5 class="modal-title">Подтвердите удаление</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      </div>
                      <div class="modal-body">
                        <p>Вы уверены, что хотите удалить это мероприятие?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelDeleteButton">Отмена</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Удалить</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal" id="successDeleteModal">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                          <h5 class="modal-title">Успешное удаление</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      </div>
                      <div class="modal-body">
                        <p>Мероприятие успешно удалено.</p>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                  document.getElementById('confirmDeleteModal').addEventListener('click', function(event) {
                    if (event.target.classList.contains('close') || event.target.classList.contains('modal')) {
                      $('#confirmDeleteModal').modal('hide');

                    }
                  });

                  document.getElementById('successDeleteModal').addEventListener('click', function(event) {
                    if (event.target.classList.contains('close') || event.target.classList.contains('modal')) {
                      $('#successDeleteModal').modal('hide');

                    }
                  });
                  // Обработчик события для кнопки "Отмена" в модальном окне подтверждения удаления
                  document.getElementById('cancelDeleteButton').addEventListener('click', function() {
                    $('#confirmDeleteModal').modal('hide');
                  });

                  function showSuccessModal() {
                    $('#successDeleteModal').modal('show');
                  }

                  // Обработчик события для кнопки "Удалить"
                  document.getElementById('myEventsTable').addEventListener('click', function(e) {
                    if (e.target.classList.contains('deleteEventButton')) {
                      var eventId = e.target.dataset.eventId;
                      $('#confirmDeleteModal').modal('show');
                      // Сохраняем идентификатор мероприятия в атрибуте data-event-id модального окна подтверждения удаления
                      document.getElementById('confirmDeleteButton').setAttribute('data-event-id', eventId);
                    }
                  });

                  // Обработчик события для кнопки "Удалить" в модальном окне подтверждения удаления
                  document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    // Получаем идентификатор мероприятия из атрибута data-event-id
                    var eventId = this.getAttribute('data-event-id');
                    // Закрываем модальное окно подтверждения удаления
                    $('#confirmDeleteModal').modal('hide');
                    // Вызываем функцию удаления мероприятия
                    deleteEvent(eventId);
                  });

                  // Функция для удаления мероприятия
                  function deleteEvent(eventId) {
                    // Отправить запрос на сервер для удаления мероприятия
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'delete_event.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                      if (xhr.status === 200) {
                        // Обновить список мероприятий после удаления
                        // Например, перезагрузить страницу или удалить соответствующую строку из таблицы
                        showSuccessModal();
                      }
                    };
                    xhr.send('eventId=' + encodeURIComponent(eventId));
                  }
                </script>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script>
    function enableEdit() {
      document.getElementById("inputName").readOnly = false;
      document.getElementById("inputLastName").readOnly = false;
      document.getElementById("exampleInputEmail1").readOnly = false;
      document.getElementById("inputUsername").readOnly = false;
      document.getElementById("editButton").style.display = "none";
      document.getElementById("saveButton").style.display = "block";
      enableFileInput();
    }

    function disableEdit() {
      document.getElementById("inputName").readOnly = true;
      document.getElementById("inputLastName").readOnly = true;
      document.getElementById("exampleInputEmail1").readOnly = true;
      document.getElementById("inputUsername").readOnly = true;
      document.getElementById("editButton").style.display = "block";
      document.getElementById("saveButton").style.display = "none";
      disableFileInput();
    }


    function enableFileInput() {
      document.getElementById("exampleInputFile").disabled = false;
    }

    function disableFileInput() {
      document.getElementById("exampleInputFile").disabled = true;
    }

    document.getElementById("editButton").addEventListener("click", function() {
      enableEdit();
    });

    document.getElementById("profileForm").addEventListener("submit", function(event) {
      event.preventDefault();

      var formData = new FormData(this);

      var xhr = new XMLHttpRequest();
      xhr.open('POST', window.location.href, true);

      xhr.onload = function() {
        if (xhr.status === 200) {
          disableEdit();
          var reader = new FileReader();
          reader.onload = function(e) {
            document.getElementById('profileImage').src = e.target.result;
          }
          reader.readAsDataURL(formData.get('image'));
        }
      };

      xhr.onerror = function() {
        console.error('Ошибка при отправке запроса');
      };

      xhr.send(formData);
    });


    // При загрузке страницы проверяем, есть ли сохраненные данные в localStorage
    window.onload = function() {
      var savedContacts = JSON.parse(localStorage.getItem('contacts'));
      if (savedContacts) {
        var tableBody = document.getElementById("additionalContacts");
        savedContacts.forEach(function(contact) {
          var newRow = tableBody.insertRow();
          newRow.innerHTML = '<td>' + contact.contactType + '</td><td>' + contact.contactValue + '</td><td><button class="btn btn-danger btn-sm delete-contact" data-type="' + contact.contactType + '" data-value="' + contact.contactValue + '">&times;</button></td>';
        });
        // Добавляем обработчик события на все кнопки удаления
        var deleteButtons = document.getElementsByClassName('delete-contact');
        for (var i = 0; i < deleteButtons.length; i++) {
          deleteButtons[i].addEventListener('click', function() {
            var contactType = this.getAttribute('data-type');
            var contactValue = this.getAttribute('data-value');
            // Удаление из базы данных
            deleteContactFromDatabase(contactType, contactValue);
            var row = this.parentNode.parentNode;
            row.parentNode.removeChild(row);
            // Обновляем localStorage после удаления
            updateLocalStorage();
          });
        }
      }
    };

    document.getElementById("saveContactButton").addEventListener("click", function() {
      // Получение данных из формы
      var contactType = document.getElementById("contactType").value;
      var contactValue = document.getElementById("contactValue").value;

      // Проверка наличия значений в полях формы
      if (contactType.trim() === "") {
        document.getElementById("contactTypeError").innerText = "Пожалуйста, выберите тип контакта";
        return; // Отмена отправки формы
      } else {
        document.getElementById("contactTypeError").innerText = ""; // Очистка сообщения об ошибке
      }

      if (contactValue.trim() === "") {
        document.getElementById("contactValueError").innerText = "Пожалуйста, введите контакт";
        return; // Отмена отправки формы
      } else {
        document.getElementById("contactValueError").innerText = ""; // Очистка сообщения об ошибке
      }

      // Проверка корректности формата введенных данных в зависимости от выбранного типа контакта
      if (contactType === "Почта" && !isValidEmail(contactValue)) {
        document.getElementById("contactValueError").innerText = "Пожалуйста, введите корректный адрес электронной почты";
        return; // Отмена отправки формы
      }

      if (contactType === "Телефон" && !isValidPhone(contactValue)) {
        document.getElementById("contactValueError").innerText = "Пожалуйста, введите корректный номер телефона";
        return; // Отмена отправки формы
      }

      // Создание объекта FormData для отправки данных на сервер
      var formData = new FormData();
      formData.append('contactType', contactType);
      formData.append('contactValue', contactValue);

      // Отправка данных на сервер с использованием XMLHttpRequest
      var xhr = new XMLHttpRequest();
      xhr.open('POST', window.location.href, true); // Отправка на тот же URL, где находится текущая страница
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Добавление новой строки в таблицу на странице пользователя
          var tableBody = document.getElementById("additionalContacts");
          var newRow = tableBody.insertRow();
          newRow.innerHTML = '<td>' + contactType + '</td><td>' + contactValue + '</td><td><button class="btn btn-danger btn-sm delete-contact" data-type="' + contactType + '" data-value="' + contactValue + '">&times;</button></td>';
          // Добавляем обработчик события на кнопку удаления
          var deleteButton = newRow.querySelector('.delete-contact');
          deleteButton.addEventListener('click', function() {
            var contactType = this.getAttribute('data-type');
            var contactValue = this.getAttribute('data-value');
            // Удаление из базы данных
            deleteContactFromDatabase(contactType, contactValue);
            var row = this.parentNode.parentNode;
            row.parentNode.removeChild(row);
            // Обновляем localStorage после удаления
            updateLocalStorage();
          });

          // Сохранение данных в localStorage
          updateLocalStorage();

          // Очистка формы после успешного добавления контакта
          document.getElementById("contactType").value = "";
          document.getElementById("contactValue").value = "";

          // Закрытие модального окна
          $('#addContactModal').modal('hide');
        } else {
          console.error('Ошибка при отправке запроса');
        }
      };
      xhr.onerror = function() {
        console.error('Ошибка при отправке запроса');
      };
      xhr.send(formData);
    });

    // Функция для проверки корректности адреса электронной почты
    function isValidEmail(email) {
      // Простая регулярка для проверки адреса электронной почты
      var emailRegex = /\S+@\S+\.\S+/;
      return emailRegex.test(email);
    }

    // Функция для проверки корректности номера телефона
    function isValidPhone(phone) {
      // Простая регулярка для проверки номера телефона
      var phoneRegex = /^\+?\d{1,3}[- ]?\(?(?:\d{2,3})\)?[- ]?\d{3}[- ]?\d{2}[- ]?\d{2}$/;
      return phoneRegex.test(phone);
    }



    // Функция для удаления контакта из базы данных
    function deleteContactFromDatabase(contactType, contactValue) {
      // Создание объекта FormData для отправки данных на сервер
      var formData = new FormData();
      formData.append('deleteContact', true);
      formData.append('contactType', contactType);
      formData.append('contactValue', contactValue);

      // Отправка данных на сервер с использованием XMLHttpRequest
      var xhr = new XMLHttpRequest();
      xhr.open('POST', window.location.href, true); // Отправка на тот же URL, где находится текущая страница
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log('Контакт успешно удален из базы данных');
        } else {
          console.error('Ошибка при удалении контакта из базы данных');
        }
      };
      xhr.onerror = function() {
        console.error('Ошибка при отправке запроса');
      };
      xhr.send(formData);
    }

    // Функция для обновления данных в localStorage
    function updateLocalStorage() {
      var tableRows = document.getElementById("additionalContacts").getElementsByTagName('tr');
      var contacts = [];
      for (var i = 0; i < tableRows.length; i++) {
        var cells = tableRows[i].getElementsByTagName('td');
        if (cells.length === 3) { // Проверяем, что это не заголовок таблицы
          var contactType = cells[0].innerText;
          var contactValue = cells[1].innerText;
          contacts.push({
            contactType: contactType,
            contactValue: contactValue
          });
        }
      }
      localStorage.setItem('contacts', JSON.stringify(contacts));
    }
  </script>




  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>