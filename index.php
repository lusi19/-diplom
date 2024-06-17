<?php include 'counter.php'; ?>

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
if (isset($_SESSION['user_id'])) {
  $buttonText = 'Профиль';
  $buttonLink = 'profile.php';
} else {
  $buttonText = 'Войти';
  $buttonLink = 'signUp.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Главная страница</title>
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

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="images/dgtu-logo.png">
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Главная</a></li>
          <li><a href="about.php">О нас</a></li>
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
    <section id="hero" class="hero section">
      <img src="images/5VlyCdfHE6Q.jpg" alt="" data-aos="fade-in">
      <div class="container">
        <h2 data-aos="fade-up" data-aos-delay="100" class="">Система принятия решений <br>для абитуриентов</h2>
        <p data-aos="fade-up" data-aos-delay="200">Нам важен каждый!</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="signUp.php" class="btn-get-started">Присоединиться к команде</a>
        </div>
      </div>
    </section>
    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="images/tild6333-3264-4034-b130-343339373063__2-2.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>История Донского Государственного Технического Университета</h3>
            <p class="fst-italic">
              Образование для Технологического Будущего.Мы стремимся к академическому совершенству и инновационной технической экспертизе, вооружая будущее поколение лидеров в области техники и технологий.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>Качество Образования: Профессиональные преподаватели и современные методики обучения гарантируют высокий уровень знаний.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Исследовательские Возможности: Лаборатории и исследовательские центры обеспечивают студентов возможностью взаимодействовать с передовыми технологиями.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Партнерство с Индустрией: Мы сотрудничаем с ведущими компаниями для обеспечения стажировок и карьерных возможностей для наших студентов.</span></li>
            </ul>
            <a href="about.php" class="read-more"><span>Подробнее</span><i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </section>
    <section id="counts" class="section counts">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end=" 45000" data-purecounter-duration="1" class="purecounter"></span>
              <p class="">Студентов</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="27" data-purecounter-duration="1" class="purecounter"></span>
              <p class="">Факультета</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="650" data-purecounter-duration="1" class="purecounter"></span>
              <p class="">Преподавателей</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
              <p class="">Филиалов</p>
            </div>
          </div>
        </div>
      </div>
      <section id="courses" class="courses section">
        <div class="container section-title" data-aos="fade-up">
          <h2>Факультеты</h2>
          <p class="">Популярные направления подготовки</p>
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="course-item">
                  <img src="images/4.jpg" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">Информатика и вычислительная техника</p>
                    </div>
                    <h3><a href="#">Факультет Информатика и вычислительная техника ДГТУ</a></h3>
                    <p class="description">предоставляет уникальные образовательные программы, сочетающие теоретические знания с практическим опытом, для подготовки специалистов в области информационных технологий и программирования.</p>
                    <div class="trainer d-flex justify-content-between align-items-center">
                      <div class="trainer-profile d-flex align-items-center">
                        <img src="images/fCNV-9HwAUR8SmDz2Do_fqQtrGfIcmqUgI9JnWuZ3Vy3MaqneEzGKfaRgbckpAnIBMKdWV5M.jpg" class="img-fluid" alt="">
                        <span style="padding-left: 10px; font-weight: 600;font-size: 16px;">Декан факультета <br>Поркшеян Виталий Маркосович</span>
                      </div>
                      <div class="trainer-rank d-flex align-items-center">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                <div class="course-item">
                  <img src="images/1by0LuZrbi8.jpg" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">Юридический</p>
                    </div>
                    <h3><a href="#">Факультет Юридический ДГТУ</a></h3>
                    <p class="description">предоставляет высококачественное образование в области права, развивая навыки анализа законодательства, практического применения правовых норм и формирования профессиональной этики.</p>
                    <div class="trainer d-flex justify-content-between align-items-center">
                      <div class="trainer-profile d-flex align-items-center">
                        <img src="images/i.jpg" class="img-fluid" alt="">
                        <span style="padding-left: 10px; font-weight: 600;font-size: 16px;">Декан факультета <br> Исакова Юлия<br> Игоревна</span>
                      </div>
                      <div class="trainer-rank d-flex align-items-center">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
                <div class="course-item">
                  <img src="images/4-25.jpg" class="img-fluid" alt="...">
                  <div class="course-content">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <p class="category">Технология Машиностроения</p>
                    </div>
                    <h3><a href="#">Факультет Технологии Машиностроения ДГТУ</a></h3>
                    <p class="description">предоставляет студентам глубокие знания в области проектирования, производства и эксплуатации машин и оборудования, обеспечивая комплексное понимание современных технологий и инженерных методов.</p>
                    <div class="trainer d-flex justify-content-between align-items-center">
                      <div class="trainer-profile d-flex align-items-center">
                        <img src="images/5.JPG" class="img-fluid" alt="">
                        <span style="padding-left: 10px; font-weight: 600;font-size: 16px;">Декан факультета<br> Чаава Михаил <br>Мегонович</span>
                      </div>
                      <div class="trainer-rank d-flex align-items-center">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
      <div class="container section-title" data-aos="fade-up">
        <h2>ДГТУ</h2>
        <p class="">Руководство ВУЗА</p>
        <section id="trainers-index" class="section trainers-index">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                  <img src="images/CQuna3ViTJE.jpg" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>МЕСХИ БЕСАРИОН<br> ЧОХОЕВИЧ</h4>
                    <span>Ректор ВУЗА</span>
                    <p>
                      Доктор технических наук, профессор<br>
                      Административная деятельность:
                      Служба ректора<br>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="member">
                  <img src="images/6.JPG" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>ЛЕБЕДЕНКО ВЯЧЕСЛАВ ГЕОРГИЕВИЧ</h4>
                    <span>Проректор по административно-хозяйственной работе</span>
                    <p>
                      кандидат технических наук, доцент<br>
                      Административная деятельность:
                      Службы по административно-хозяйственной работе<br>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                  <img src="images/7.JPG" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>МОЗГОВОЙ АНДРЕЙ ВЛАДИМИРОВИЧ</h4>
                    <span>Проректор по стратегическому и цифровому развитию</span>
                    <p>
                      Административная деятельность:
                      Службы проректора по стратегическому и цифровому развитию<br>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                  <img src="images/8.JPG" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>ПОНОМАРЕВА СВЕТЛАНА ВИКТОРОВНА</h4>
                    <span>Проректор по учебной работе и непрерывному образованию</span>
                    <p>
                      кандидат биологических наук
                      Административная деятельность:
                      Служба проректора по учебной работе и непрерывному образованию
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                  <img src="images/9.jpg" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>СВИСТУНОВ АНДРЕЙ ВЛАДИМИРОВИЧ</h4>
                    <span>Проректор по проектной деятельности</span>
                    <p>
                      Административная деятельность:
                      Служба проректора по проектной деятельности
                      Управление инновационного развития и организации проектной деятельности
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                  <img src="images/10.JPG" class="img-fluid" alt="">
                  <div class="member-content">
                    <h4>ЕФРЕМЕНКО ИННЕССА НИКОЛАЕВНА</h4>
                    <span>Проректор по научно-исследовательской работе и инновационной деятельности</span>
                    <p>
                      Административная деятельность:
                      Службы по научно-исследовательской работе и инновационной деятельности </p>
                  </div>
                </div>
        </section>
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
          <form action="subscribe.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>
        <div class="modal" id="myModal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"></p>
          </div>
        </div>



      </div>
    </div>
  </footer>
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