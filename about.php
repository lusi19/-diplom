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

// Определение текста и ссылки кнопки в зависимости от наличия сессии
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
  <title>О нас</title>
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
        <img src="images/dgtu-logo.png">
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="">Главная</a></li>
          <li><a href="about.php" class="active">О нас</a></li>
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
          <li><a href="contact.php">Контакты</a></li>

          <a href="<?php echo $buttonLink; ?>" class="btn-getstarted"><?php echo $buttonText; ?></a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>
  <main class="main">
    </nav>
    </div>
    <section id="about-us" class="section about-us">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="images/139146_original.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>История Донского Государственного Технического Университета</h3>
            <p class="fst-italic">
              Донской государственный технический университет (ДГТУ) имеет богатую историю, включающую множество важных событий.
            </p>
            <ul>
              <li> <span>1947 год: Основание Донского института инженеров железнодорожного транспорта (ДИИЖТ) как ведущего образовательного учреждения для подготовки специалистов в области железнодорожного транспорта.</span></li>
              <li> <span>1957 год: Переименование ДИИЖТ в Ростовский институт инженеров железнодорожного транспорта (РИИЖТ) в связи с расширением спектра образовательных программ и направлений.</span></li>
              <li><span>1993 год: Присвоение статуса университета Ростовскому институту инженеров железнодорожного транспорта (РИИЖТ), отразившего увеличение количества факультетов и расширение образовательных программ.</span></li>
              <li> <span>2009 год: Преобразование РИИЖТ в Донский государственный технический университет (ДГТУ), что свидетельствует о более широком охвате технических специальностей и инженерного образования в университете.</span></li>
              <li> <span>2013 год: Построение и введение в эксплуатацию современного кампуса, обеспечивающего студентам и преподавателям комфортные условия для обучения и исследований.</span></li>
              <li> <span>2020 год: Активное развитие инновационной и исследовательской деятельности, в том числе участие в международных научных проектах и инициативах.</span></li>
              <li> <span>2021 год: Значительное расширение международного сотрудничества и участие в обменных программах с ведущими университетами по всему миру.</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <section id="stats-about" class="stats-about section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="45000" data-purecounter-duration="1" class="purecounter"></span>
              <p class="">Студентов</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1" class="purecounter"></span>
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
    </section>
    <section id="testimonials" class="testimonials section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Спонсорство</h2>
        <p class="">Наши партнеры</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 2,
                  "spaceBetween": 20
                }
              }
            }
          </script>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="images/189bizon.jpg" class="testimonial-img" alt="">
                  <h3>ООО "Бизон Юг"</h3>
                  <p>
                    <span>Наша миссия — обеспечивать аграриев России современной сельхозтехникой, качественными запчастями и надежным сервисом. Мы предоставляем клиентам возможность выбора от простых и доступных до самых высокотехнологичных решений.</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="images/140-gazprom-krasnodar.jpg" class="testimonial-img" alt="">
                  <h3>OOO "Газпром Трансгаз Краснодар"</h3>
                  <p>
                    <span>"Энергия Будущего!" Мы хотим обратить внимание, прежде всего, на наш кадровый потенциал, работу с молодежью, обмен опытом и создание дополнительных возможностей для профессионального роста, и развития нового поколения газовиков.</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="images/47spetsvuzavtomatika.jpg" class="testimonial-img" alt="">
                  <h3>ФГАНУ НИИ "Спецвузавтоматика"</h3>
                  <p>
                    <span>Наши усилия направлены на формирование Института как современной компании работающей в сфере передовых технологий и являющейся точкой роста инновационной экономики Ростовской области</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="images/6163eec4bddb2.jpg" class="testimonial-img" alt="">
                  <h3>ООО "Росельмаш"</h3>
                  <p>
                    <span>Ростсельмаш — современная компания с богатой историей, фирменным подходом: стремлением к качеству, развитию и совершенствованию.</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="images/Screenshot_5.png" class="testimonial-img" alt="">
                  <h3>«Киностудия Союзмультфильм»</h3>
                  <p>
                    <span>Детство — это удивительное путешествие, а наше длится с 1936 года</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
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
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>