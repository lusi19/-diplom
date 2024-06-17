<?php
session_start();

// Обновление статуса пользователя в базе данных
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $servername = "localhost";
  $username = "root";
  $password = "gonedone24@L";
  $dbname = "diplom";
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Проверка соединения с базой данных
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Запрос на обновление статуса пользователя
  $sql = "UPDATE users SET last_activity_time = NOW() WHERE id = $user_id";

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "Ошибка при обновлении статуса пользователя: " . $conn->error;
  }

  $conn->close();
}
$db_host = 'localhost';
$db_username = 'root';
$db_password = "gonedone24@L";
$db_name = 'diplom';
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (!$conn) {
  die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT first_name, email FROM users WHERE id = $user_id";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['first_name'];
    $userEmail = $row['email'];
  } else {
    echo "Пользователь не найден в базе данных.";
  }
  $buttonText = 'Профиль';
  $buttonLink = 'profile.php';
} else {
  $buttonText = 'Войти';
  $buttonLink = 'signUp.php';
}
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$eventId = $_GET['id'];
$sql = "SELECT * FROM EVENTS WHERE id = $eventId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $eventTitle = $row['title'];
  $eventContent = $row['content'];
} else {
  $eventTitle = "Мероприятие не найдено";
  $eventContent = "Извините, запрашиваемое мероприятие не найдено.";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Получение данных из формы
  $name = $_POST['name'];
  $email = $_POST['email'];

  // Проверка, зарегистрирован ли уже пользователь на мероприятие
  $sql_check_registration = "SELECT * FROM event_participants WHERE event_id = $eventId AND user_id = $user_id";
  $result_check_registration = mysqli_query($conn, $sql_check_registration);
  if (mysqli_num_rows($result_check_registration) > 0) {
    // Если запись существует, устанавливаем флаг для отображения модального окна с предупреждением
    $show_modal_warning = true;
  } else {
    // Если запись не существует, выполняем запрос на добавление пользователя
    $sql_insert_registration = "INSERT INTO event_participants (event_id, user_id, name, email) VALUES ('$eventId', '$user_id', '$name', '$email')";
    if (mysqli_query($conn, $sql_insert_registration)) {
      // После успешного добавления записи показываем модальное окно с успешной регистрацией
      $show_modal_success = true;
    } else {
      echo "Ошибка при регистрации: " . mysqli_error($conn);
    }
  }
}

// Закрытие соединения с базой данных
$conn->close();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Мероприятие</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<style>
  .form-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 3px solid #f1f1f1;
    z-index: 9;
  }

  .form-container {
    max-width: 300px;
    padding: 10px;
    background-color: white;
  }

  .form-container input[type=text],
  .form-container input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    border: none;
    background: #f1f1f1;
  }

  .form-container input[type=text]:focus,
  .form-container input[type=password]:focus {
    background-color: #ddd;
    outline: none;
  }

  .form-container .btn {
    background-color: #1B6B57;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
    opacity: 0.8;
    font-size: 15px;
    font-weight: bold;
  }

  .form-container .cancel {
    background-color: #4E7C70;
  }

  .form-container .btn:hover,
  .open-button:hover {
    opacity: 1;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
</style>

<body>
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="images/dgtu-logo.png" alt="">
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="">Главная</a></li>
          <li><a href="about.php">О нас </a></li>
          <li><a href="courses.php">Факультеты</a></li>
          <li><a href="events.php">Новости</a></li>
          <li><a href="merop.php">Мероприятия</a></li>
          <li><a href="analitics.php">Аналитика</a></li>
          <li class="dropdown"><a href="#"><span>Допольнительно</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="https://donstu.ru/abiturient/konkursnyye-ranzhirovannyye-spiski/">Ранжированные Списки</a></li>
              <li><a href="kalendar.php">Календарь абитуриента</a></li>

              <li><a href="https://abiturient.donstu.ru/Infrastruktura/">Инфраструктура</a></li>
              <li><a href="https://donstu.ru/university/filialy/">Филиалы</a></li>
              <li><a href="https://donstu.ru/university/faculties/institut-voyennogo-obrazovaniya/voyennyy-uchebnyy-tsentr/">ВУЦ</a></li>

              <li class="dropdown"><a href="#"><span>Программы поддержки</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="https://donstu.ru/abiturient/zelenaya-volna/index.php">Зеленая волна</a></li>
                  <li><a href="https://abiturient.donstu.ru/bonus-dlya-pervokursnikov/">Бонусы первокурсникам</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="#"><span>Допольнительное образование</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="https://dnk-rostobl.donstu.ru/academy-of-applicants/">Подготовка к поступлению</a></li>
                  <li><a href="https://dnk-rostobl.donstu.ru/childrens-university/">Детский Университет</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="contact.php">Контакты</a></li>\
          <a href="<?php echo $buttonLink; ?>" class="btn-getstarted"><?php echo $buttonText; ?></a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <main class="main">
    <section id="courses-course-details" class="courses-course-details section">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-8">
            <img src="images/dgtu.jpg" class="img-fluid" alt="">
            <h3><?php echo $eventTitle; ?> </h3>
            <p>
              22 октября 2023 года состоится День открытых дверей ДГТУ. Мероприятие состоится в очном формате по адресу г. Ростов-на-Дону, пл. Гагарина, 1. Торжественная часть будет транслироваться онлайн. </p>
          </div>
          <div class="col-lg-4">
            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Событие</h5>
              <p>День открытых дверей </a></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Место проведения</h5>
              <p>Площадь Гагарина, 1</p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Дата проведения </h5>
              <p>22 октября 2023 года</p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Время проведения</h5>
              <p>09:00-13:00</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="tabs" class="tabs section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">09:00-10:00</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-2">10:00-11:30</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-3">11.30-13.00</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Выставка факультетов, колледжей, лицея № 50 при ДГТУ и Гимназии ДГТУ, профтестирование</p>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Встреча с руководством вуза, ответы на вопросы абитуриентов, розыгрыш памятных подарков от партнёров вуза</p>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <p>Презентации факультетов, колледжей, школ ДГТУ, Военного учебного центра и Т-университета, консультации приемной комиссии, проведение мастер-классов и экскурсий</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <button class="eventbutton" type="button" onclick="<?php echo isset($_SESSION['user_id']) ? 'openForm(); checkRegistration();' : 'redirectToSignUpPage();'; ?>">Записаться на Мероприятие</button>
    <div class="form-popup" id="myForm">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $eventId; ?>" method="post" class="form-container">
        <h1>Записаться</h1>
        <label for="name"><b>Имя</b></label>
        <input type="text" placeholder="Ваше имя" name="name" value="<?php echo $userName; ?>" required>
        <label for="email"><b>Е-мейл</b></label>
        <input type="text" placeholder="Ваш е-мейл" name="email" value="<?php echo $userEmail; ?>" required>
        <button type="submit" class="btn">Отправить</button>
      </form>

    </div>
  </main>
  <footer id="footer" class="footer position-relative">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="">Донской Государственный Технический Университет</span>
          </a>
          <div class="footer-contact pt-3">
            344003, Ростовская Область, г.о. Город Ростов-на-дону, г Ростов-на-дону, пл Гагарина, зд. 1
            <p class="mt-3"><strong>Телефон:</strong> <span>+7 (800) 100-19-30</span></p>
            <p><strong> Почтовые адреса:</strong> <span>reception@donstu.ru</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="https://vk.com/donstu"><i class="bi bi-vk-x"></i></a>
            <a href="https://www.instagram.com/dstu_official/"><i class="bi bi-instagram"></i></a>
            <a href="https://www.tiktok.com/@dstu_live?lang=en"><i class="bi bi-tiktok"></i></a>
            <a href="https://t.me/s/dstu_live"><i class="bi bi-telegram"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Наши сервисы</h4>
          <ul>
            <li><a href="https://donstu.ru">Официальный сайт</a></li>
            <li><a href="https://online.donstu.ru">Официальный сайт приемной комиссии</a></li>

            <li><a href="https://do.skif.donstu.ru">Библиотека электронных ресурсов СКИФ</a></li>

            <li><a href="https://profdstu.ru">Официальный сайт Профкома </a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-3 footer-links">
        </div>
        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Рассылка новостей</h4>
          <p>Подпишись на нашу рассылку и будь в курсе всех новостей!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>
      </div>
    </div>
  </footer>
  <!-- Модальное окно об уже существующей регистрации -->
  <div id="warningModal" class="modal" <?php if (isset($show_modal_warning) && $show_modal_warning) echo 'style="display: block;"'; ?>>
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Вы уже зарегистрировались на мероприятие!</p>
    </div>
  </div>

  <!-- Модальное окно об успешной регистрации -->
  <div id="successModal" class="modal" <?php if (isset($show_modal_success) && $show_modal_success) echo 'style="display: block;"'; ?>>
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Вы успешно зарегистрировались на мероприятие!</p>
    </div>
  </div>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function openForm() {
      var form = document.getElementById("myForm");
      form.style.display = "block";
      document.body.classList.add("show-popup");
    }

    function closeForm() {
      var form = document.getElementById("myForm");
      form.style.display = "none";
      document.body.classList.remove("show-popup");
    }

    function redirectToSignUpPage() {
      window.location.href = "signUp.php";
    }
    var modal = document.getElementById("successModal");
    var span = document.getElementsByClassName("close")[0];

    console.log("Modal:", modal);
    console.log("Span:", span);

    function openModal() {
      console.log("Opening modal");
      modal.style.display = "block";
    }

    span.onclick = function() {
      console.log("Closing modal by span click");
      modal.style.display = "none";
    };

    window.onclick = function(event) {
      if (event.target == modal) {
        console.log("Closing modal by window click");
        modal.style.display = "none";
      }
    };


    function checkRegistration() {
      // Выполняем AJAX-запрос на сервер для проверки регистрации пользователя
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Если запрос выполнен успешно и вернул данные
          if (this.responseText == 'not_registered') {
            // Если пользователь еще не зарегистрирован, открываем форму для записи
            openForm();
          } else if (this.responseText == 'error') {
            // Если произошла ошибка при выполнении запроса
            console.log("Ошибка при проверке регистрации пользователя.");
          }
        }
      };
      // Передаем id мероприятия в запросе
      xhttp.open("GET", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>?check_registration&id=<?php echo $eventId; ?>", true);
      xhttp.send();
    }



    // Функция для открытия модального окна о повторной регистрации
    function openWarningModal() {
      var warningModal = document.getElementById("warningModal");
      warningModal.style.display = "block";
    }

    // Находим элементы модального окна и крестика для закрытия
    var warningModal = document.getElementById("warningModal");
    var warningModalCloseBtn = warningModal.getElementsByClassName("close")[0];

    // Функция для закрытия модального окна о повторной регистрации
    function closeWarningModal() {
      warningModal.style.display = "none";
    }

    // Закрываем модальное окно при нажатии на крестик
    warningModalCloseBtn.onclick = function() {
      closeWarningModal();
    };

    // Закрываем модальное окно при нажатии вне его области
    window.onclick = function(event) {
      if (event.target == warningModal) {
        closeWarningModal();
      }
    };
    // Находим элементы модального окна успешной регистрации и крестика для закрытия
    var successModal = document.getElementById("successModal");
    var successModalCloseBtn = successModal.getElementsByClassName("close")[0];

    // Функция для закрытия модального окна успешной регистрации
    function closeSuccessModal() {
      successModal.style.display = "none";
    }

    // Закрываем модальное окно при нажатии на крестик
    successModalCloseBtn.onclick = function() {
      closeSuccessModal();
    };

    // Закрываем модальное окно при нажатии вне его области
    window.onclick = function(event) {
      if (event.target == successModal) {
        closeSuccessModal();
      }
    };
  </script>
</body>

</html>