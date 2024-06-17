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

// Обновление статуса пользователя в базе данных
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  // Запрос на обновление статуса пользователя
  $sql = "UPDATE users SET last_activity_time = NOW() WHERE id = $user_id";

  if ($conn->query($sql) !== TRUE) {
    echo "Ошибка при обновлении статуса пользователя: " . $conn->error;
  }
}

if (isset($_SESSION['user_id'])) {
  $buttonText = 'Профиль';
  $buttonLink = 'profile.php';
} else {
  $buttonText = 'Войти';
  $buttonLink = 'signUp.php';
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Факультеты</title>
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
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

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

  .course-item img {
    width: 100%;
    /* Желаемая ширина изображения */
    height: 200px;
    /* Желаемая высота изображения */
    object-fit: cover;
    /* Обрезка изображения по размерам контейнера */
  }

  .trainer-profile img {
    width: 50px;
    /* Желаемая ширина изображения декана */
    height: 50px;
    /* Желаемая высота изображения декана */
    object-fit: cover;
    /* Обрезка изображения по размерам контейнера */
    border-radius: 50%;
    /* Закругление углов для создания круглой формы */
  }

  button {
    color: var(--contrast-color);
    background: #56BEA4;
    border: 0;
    padding: 10px 30px 12px 30px;
    transition: 0.4s;
    border-radius: 50px;

  }

  /* Новый стиль для поля поиска */
  .search-container {
    right: 10px;
    top: 10px;
    display: flex;
    align-items: center;
    background-color: white;
    padding: 5px;
    border-radius: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .search-container input[type=text] {
    padding: 5px;
    border: none;
    outline: none;
    background: none;
    flex: 1;
    /* Растягиваем поле ввода на всю доступную ширину */
  }

  .search-container button {
    border: none;
    background: none;
    outline: none;
  }

  .search-container button i {
    color: #56BEA4;
    /* Зеленый цвет */
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
          <li><a href="courses.php" class="active">Факультеты</a></li>
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
    <section id="courses" class="courses section">
      <div class="container section-title" data-aos="fade-up">

        <p class="">Наши Факультеты</p>
        <br>
        <div class="search-container">
          <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Поиск">
          <button><i class='bx bx-search'></i></button>
        </div>
        <br>
        <div class="container">
          <div class="row">

          </div>
          <br>
          <div class="text-center">
            <button id="load-more">Загрузить еще</button>
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
      var loadMoreButton = document.getElementById('load-more');
      var facultiesContainer = document.querySelector('.row');
      var allFaculties = [];
      var displayedFaculties = [];
      var limit = 6;
      var offset = 0;

      function displayFaculties(faculties) {
        faculties.forEach(faculty => {
          var facultyContainer = document.createElement('div');
          facultyContainer.classList.add('col-lg-4', 'col-md-6', 'd-flex', 'align-items-stretch');
          facultyContainer.innerHTML = `
        <div class="course-item">
          <img src="${faculty.image}" class="img-fluid" alt="...">
          <div class="course-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <p class="category">${faculty.category}</p>
            </div>
            <h3><a href="course-details.php?id=${faculty.id}">${faculty.name}</a></h3>
            <p class="description">${faculty.description}</p>
            <div class="trainer d-flex justify-content-between align-items-center">
              <div class="trainer-profile d-flex align-items-center">
                <img src="${faculty.dean_image}" class="img-fluid" alt="">
                <span style="padding-left: 10px; font-weight: 600;font-size: 16px;">Декан факультета <br>${faculty.dean_name}</span>
              </div>
              <div class="trainer-rank d-flex align-items-center"></div>
            </div>
          </div>
        </div>
      `;
          facultiesContainer.appendChild(facultyContainer);
        });
      }

      function loadFaculties() {
        var facultiesToDisplay = allFaculties.slice(offset, offset + limit);
        displayFaculties(facultiesToDisplay);
        displayedFaculties = displayedFaculties.concat(facultiesToDisplay);
        offset += limit;

        if (offset >= allFaculties.length) {
          loadMoreButton.style.display = 'none';
        }
      }

      function searchTable() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toUpperCase();
        facultiesContainer.innerHTML = ''; // Clear current displayed faculties

        var filteredFaculties = allFaculties.filter(faculty =>
          faculty.name.toUpperCase().indexOf(filter) > -1
        );

        displayFaculties(filteredFaculties);
      }

      // Fetch all faculties on page load
      fetch('facultiets.php')
        .then(response => response.json())
        .then(data => {
          allFaculties = data.faculties;
          loadFaculties();
        })
        .catch(error => {
          console.error('Error fetching faculties:', error);
        });

      loadMoreButton.addEventListener('click', function() {
        loadFaculties();
      });

      var searchInput = document.getElementById('searchInput');
      searchInput.addEventListener('keyup', function() {
        searchTable();
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