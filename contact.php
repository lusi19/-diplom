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
  <title>Контакты</title>
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
          <li><a href="about.php">О нас</a></li>
          <li><a href="courses.php">Факультеты</a></li>
          <li><a href="events.php">Новости</a></li>
          <li><a href="merop.php">Мероприятия</a></li>
          <li><a href="analitics.php">Аналитика</a></li>
          <li class="dropdown"><a href="#"><span>Допольнительно</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="https://donstu.ru/abiturient/konkursnyye-ranzhirovannyye-spiski/">Ранжированные Списки</a></li>
              <li><a href="kalendar.php" >Календарь абитуриента</a></li>

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
          <li><a href="contact.php" class="active">Контакты</a></li>
          <a href="<?php echo $buttonLink; ?>" class="btn-getstarted"><?php echo $buttonText; ?></a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <main class="main">
    <section id="contact" class="contact section">
      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe style="border:0; width: 100%; height: 300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3172.742927414681!2d39.70882249977046!3d47.23848517495603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40e3bbd25efc8dab%3A0xe71795934da757ba!2z0JTQvtC90YHQutC-0Lkg0LPQvtGB0YPQtNCw0YDRgdGC0LLQtdC90L3Ri9C5INGC0LXRhdC90LjRh9C10YHQutC40Lkg0YPQvdC40LLQtdGA0YHQuNGC0LXRgg!5e0!3m2!1sru!2sru!4v1711288652528!5m2!1sru!2sru" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Адрес</h3>
                <p>344003, Ростовская Область, г.о. Город Ростов-на-дону, г Ростов-на-дону, пл Гагарина, зд. 1</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Телефон</h3>
                <p>+7 (800) 100-19-30</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Адрес электронной почты</h3>
                <p>reception@donstu.ru</p>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <form action="feedback.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Введите Имя" required="">
                </div>
                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Введите адрес электронной почты" required="">
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Тема сообщения" required="">
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Текс сообщения" required=""></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Ваше сообщение отправлено!</div>
                  <button type="submit">Отправить</button>
                </div>
              </div>
            </form>
          </div>
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
              if (form.getAttribute('action') === 'subscribe.php') {
                modalMessage.innerText = "Спасибо за подписку!";
              } else {
                modalMessage.innerText = "Ваше сообщение отправлено!";
              }
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