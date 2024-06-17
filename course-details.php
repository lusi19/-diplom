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
    // Обновление прошло успешно
  } else {
    echo "Ошибка при обновлении статуса пользователя: " . $conn->error;
  }

  $conn->close();
}

if (isset($_SESSION['user_id'])) {
  $buttonText = 'Профиль';
  $buttonLink = 'profile.php';
} else {
  $buttonText = 'Войти';
  $buttonLink = 'signUp.php';
}

if (isset($_GET['id'])) {
  $faculty_id = $_GET['id'];
} else {
  echo "ID факультета не передан";
  exit; // Прекращаем выполнение скрипта, если ID факультета не передан
}

// Получаем информацию о факультете из базы данных
$servername = "localhost";
$username = "root";
$password = "gonedone24@L";
$dbname = "diplom";
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения с базой данных
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Запрос на получение информации о факультете по ID
$sql = "SELECT * FROM faculty_details WHERE id = $faculty_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Выводим данные о факультете на страницу
  $row = $result->fetch_assoc();
  $faculty_name = $row["faculty_name"];
  $faculty_info = $row["faculty_info"];
  $faculty_logo = $row["faculty_logo"];
  $faculty_number_1 = $row["faculty_number_1"];
  $faculty_number_2 = $row["faculty_number_2"];
  $faculty_number_3 = $row["faculty_number_3"];
  $faculty_address = $row["faculty_address"];
  $faculty_vk_link = $row["faculty_vk_link"];
  $faculty_email = $row["faculty_email"];
  $faculty_work_time = $row["faculty_working_hours"];
} else {
  echo "Информация о факультете не найдена";
  exit; // Прекращаем выполнение скрипта, если информация о факультете не найдена
}

// Запрос на получение информации о кафедрах факультета
$sql = "SELECT * FROM departments WHERE faculty_id = $faculty_id";
$result = $conn->query($sql);

$departments = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
  }
} else {
  $departments = [];
}

$sql = "SELECT * FROM educational_programs WHERE faculty_id = $faculty_id";
$result = $conn->query($sql);

$educational_programs = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $educational_programs[] = $row;
  }
} else {
  echo "No educational programs found for this faculty.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Факультет</title>
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
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
  }

  .close {
    position: absolute;
    top: 10px;
    right: 10px;
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
          <li><a href="contact.php">Контакты</a></li>
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
          <div class="col-lg-7">
            <div class="logo-container">
              <img src="<?php echo $faculty_logo; ?>" class="img-fluid" alt="">
            </div>
            <h3><?php echo $faculty_name; ?></h3>
            <p><?php echo $faculty_info; ?></p>
          </div>
          <div class="col-lg-5 ">
            <div class="faculty-card p-3" style="background-color: white; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
              <div class="faculty-details">
                <p>
                  <strong><i class="bi bi-phone"></i></strong>
                  <?php
                  $phone_numbers = array($faculty_number_1, $faculty_number_2, $faculty_number_3);
                  echo implode(', ', array_filter($phone_numbers));
                  ?>
                </p>
                <p><strong><i class="bi bi-geo-alt"></i></strong> <?php echo $faculty_address; ?></p>
                <p><strong><i class="bi bi-box-arrow-up-right"></i></strong> <a href="<?php echo $faculty_vk_link; ?>" style="color: inherit;">Вконтакте</a></p>
                <p><strong><i class="bi bi-envelope"></i></strong> <?php echo $faculty_email; ?></p>
                <p><strong><i class="bi bi-clock"></i></strong> <?php echo $faculty_work_time; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="container" data-aos="fade-up">
        <div class="row">
          <h3 class="section-title">Кафедры</h3>
          <?php if (!empty($departments)) : ?>
            <?php foreach ($departments as $department) : ?>
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="faculty-card p-3" style="background-color: white; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                  <p><?php echo htmlspecialchars($department["department_name"]); ?></p>
                  <hr style="border-top: 1px solid #444444;">
                  <div class="col-lg-12 text-left">
                    <i class="bi bi-person-fill text-primary" style="vertical-align: middle;"></i>
                    <span style="display: inline-block; vertical-align: middle;"><?php echo htmlspecialchars($department["head_of_department"]); ?></span>
                  </div>
                  <div class="col-lg-12 text-left">
                    <i class="bi bi-telephone-fill text-primary"></i>
                    <?php echo htmlspecialchars($department["phone_number_1"]); ?>
                    <?php if (!empty($department["phone_number_2"])) : ?>
                      , <?php echo htmlspecialchars($department["phone_number_2"]); ?>
                    <?php endif; ?>
                    <?php if (!empty($department["phone_number_3"])) : ?>
                      , <?php echo htmlspecialchars($department["phone_number_3"]); ?>
                    <?php endif; ?>
                  </div>
                  <div class="col-lg-12 text-left">
                    <i class="bi bi-envelope-fill text-primary"></i>
                    <span><?php echo htmlspecialchars($department["email_address"]); ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p>No departments found for this faculty.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <section>
      <div class="container" data-aos="fade-up">
        <div class="row" style="display: flex; flex-wrap: wrap; justify-content: flex-start;">
          <h3 class="section-title">Образовательные Программы</h3>
          <?php if (!empty($educational_programs)) : ?>
            <?php foreach ($educational_programs as $program) : ?>

              <div class="col-lg-6 col-md-6 mb-4">
                <div class="educational-program-card card p-3" style="background-color: white; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                  <div class="card-body">
                    <h6 class="program-code" style="color:#80889D; font: size 10px;px;letter-spacing: -.12px;line-height: 1.8rem; font-family:Arial, Helvetica, sans-serif"><strong><?php echo htmlspecialchars($program["program_code"]); ?> </strong></h6>

                    <h5 class="card-title" style="font-family:Arial, Helvetica, sans-serif"><strong><?php echo htmlspecialchars($program["program_name"]); ?> </strong></h5>
                    <p class="card-text">
                      <span style="color:#80889D;">
                        Образовательные Программы:
                        <a style="color: #1370B9;" href="<?php echo htmlspecialchars($program["program_link"]); ?>" target="_blank">
                          <?php echo htmlspecialchars($program["educational_program"]); ?>
                        </a>
                      </span>
                      <br>
                      <span style="color:#80889D;">Проходной балл:</span> <strong style="font-family:Arial, Helvetica, sans-serif; color:#444444"><?php echo htmlspecialchars($program["passing_score"]); ?></strong><br>
                      <span style="color:#80889D;">Срок обучения:</span><strong style="font-family:Arial, Helvetica, sans-serif; color:#444444"> <?php echo htmlspecialchars($program["duration"]); ?><br></strong>
                      <hr style="border-top: 1px solid #444444;">

                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: nowrap;">
                      <?php
                      $education_forms = array($program["education_form"], $program["education_form_2"], $program["education_form_3"]);

                      foreach ($education_forms as $form) {
                        if (!empty($form)) {
                          echo '<div style="background-color: #F1F4F9; color: #80889D; padding: 10px; border-radius: 10px; width: calc(33% - 20px); margin-right: 10px; margin-bottom: 10px; text-align: center;">';
                          echo '<span style="color:#80889D; font-size: 13px;">';
                          echo htmlspecialchars($form);
                          echo '<br>';
                          echo '</span>';
                          echo '</div>';
                        }
                      }
                      ?>


                      <a style="text-decoration: none; color: #FFFFFF; background-color: #1370B9; padding: 10px 15px; border-radius: 5px; display: inline-flex; align-items: center;" href="<?php echo htmlspecialchars($program["program_link"]); ?>" target="_blank">
                        <span style="margin-left: 5px;">&rarr;</span>
                      </a>
                    </div>

                    </b>
                  </div>
                </div>
              </div>



            <?php endforeach; ?>
          <?php else : ?>
            <p>No educational programs found.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

  </main>
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var form = document.querySelector('.php-email-form');
      var modal = document.getElementById('myModal');
      var closeButton = document.querySelector('.close');
      var modalMessage = document.getElementById('modalMessage');

      form.addEventListener('submit', function(event) {
        event.preventDefault();

        var emailInput = form.querySelector('input[name="email"]');
        var emailValue = emailInput.value.trim();

        if (emailValue === "") {
          modalMessage.innerText = "Введите адрес электронной почты";
          modal.style.display = 'block';
          return;
        }

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
          })
          .then(response => {
            if (response.ok) {
              modalMessage.innerText = "Спасибо за подписку!";
              modal.style.display = 'block';
              emailInput.value = '';
            } else {
              throw new Error('Network response was not ok.');
            }
          })
          .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            modalMessage.innerText = "Ошибка при отправке запроса.";
            modal.style.display = 'block';
          });
      });

      closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
      });
    });
  </script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>