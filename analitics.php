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
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Аналитика</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.0/slimselect.min.css" integrity="sha512-QhrDqeRszsauAfwqszbR3mtxV3ZWp44Lfuio9t1ccs7H15+ggGbpOqaq4dIYZZS3REFLqjQEC1BjmYDxyqz0ZA==" crossorigin="anonymous" referrerpolicy="no-referrer" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link type="text/css" rel="StyleSheet" href="https://bootstraptema.ru/plugins/2016/shieldui/style.css" />
</head>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
            <img src="images/dgtu-logo.png">
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php" class="">Главная</a></li>
                <li><a href="about.php">О нас</a></li>
                <li><a href="courses.php">Факультеты</a></li>
                <li><a href="events.php">Новости</a></li>
                <li><a href="merop.php">Мероприятия</a></li>
                <li><a href="analitic.php" class="active">Аналитика</a></li>
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

    canvas {
        max-width: 400px;
        max-height: 400px;
        width: 100% !important;
        height: auto !important;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    .chart-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;

    }

    .canvas-container {
        max-width: 400px;
    }

    .chart-and-label-container {
        display: inline-block;
        text-align: center;
        margin-right: 35px;
    }


    .chart-label {
        margin-top: 50px;
        text-align: center;
        margin-bottom: 10px;
    }

    * {
        box-sizing: border-box;
    }

    .l-radio {
        padding: 6px;
        border-radius: 50px;
        display: inline-flex;
        cursor: pointer;
        transition: background .2s ease;
        margin: 8px 0;

    }

    .l-radio:hover,
    .l-radio:focus-within {
        background: rgba(159, 159, 159, 0.1);
    }

    .l-radio input {
        vertical-align: middle;
        width: 20px;
        height: 20px;
        border-radius: 10px;
        background: none;
        border: 0;
        box-shadow: inset 0 0 0 1px #9F9F9F;
        appearance: none;
        padding: 0;
        margin: 0;
        transition: box-shadow 150ms cubic-bezier(.95, .15, .5, 1.25);
        pointer-events: none;
    }

    .l-radio input:focus {
        outline: none;
    }

    .l-radio input:checked {
        box-shadow: inset 0 0 0 6px #6743ee;
    }

    .l-radio span {
        vertical-align: middle;
        display: inline-block;
        line-height: 20px;
        padding: 0 8px;
    }
</style>

<body>
    <section id="events" class="events section">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-6 d-flex align-items-stretch mx-auto">
                    <div class="card">
                        <div class="card-body text-center" style="margin-top: 5px; padding:40px;">
                            <h5 class="card-title">Добро пожаловать на страницу "Аналитика"!</h5>
                            <p class="card-text">Эта страница предоставляет вам возможность получить статистический анализ успеваемости студентов по различным предметам и годам.<br><i class="bi bi-check-circle" style="font-size: 1.25rem;margin-right: 4px; color: #56BEA4;"></i>На правой части страницы вы увидите набор кнопок, представляющих годы.
                                Чтобы выбрать интересующий вас год, щелкните на соответствующей кнопке. По умолчанию выбран текущий год. <br><i class="bi bi-check-circle" style="font-size: 1.25rem;margin-right: 4px; color: #56BEA4;"></i>Слева располагается выпадающий список, в котором представлены направления подготовки.
                                Выберите одно из направлений подготовки, кликнув по нему в списке. <br><i class="bi bi-check-circle" style="font-size: 1.25rem;margin-right: 4px; color: #56BEA4;"></i>После выбора года и направления подготовки, на странице отобразятся круговые диаграммы, представляющие статистику успеваемости студентов по предметам.
                                Каждая диаграмма представляет один из предметов и показывает процентное соотношение студентов, получивших оценки в определенном диапазоне.<br><i class="bi bi-check-circle" style="font-size: 1.25rem;margin-right: 4px; color: #56BEA4;"></i>При наведении курсора на каждую диаграмму вы увидите соответствующий процент успеваемости.
                                Возможно также просмотреть статистику для других направлений подготовки, выбрав их из выпадающего списка.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>


<br>
<div style="display: flex; align-items: center;">
    <div class="container">
        <select id="faculty" style="max-width: 800px; margin-top:-48px; background-color: #ffffff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <option value="">Выберите направление подготовки</option>
            <?php
            // Подключение к базе данных
            $servername = "localhost";
            $username = "root";
            $password = "gonedone24@L";
            $dbname = "diplom";

            // Создание подключения
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка подключения
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Запрос к базе данных для получения списка факультетов
            $sql = "SELECT id, faculty_name FROM faculties";
            $result = $conn->query($sql);

            // Вывод опций для каждого факультета
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["faculty_name"] . "</option>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </select>
    </div>

    <div class="radio-container" style="display: inline-block;">
        <label for="f-option" class="l-radio">
            <input type="radio" id="f-option" name="year" tabindex="1" value="2019">
            <span>2019</span>
        </label>
        <label for="s-option" class="l-radio">
            <input type="radio" id="s-option" name="year" tabindex="2" value="2020">
            <span>2020</span>
        </label>
        <label for="t-option" class="l-radio">
            <input type="radio" id="t-option" name="year" tabindex="3" value="2021">
            <span>2021</span>
        </label>
        <label for="e-option" class="l-radio">
            <input type="radio" id="e-option" name="year" tabindex="4" value="2022">
            <span>2022</span>
        </label>
        <label for="w-option" class="l-radio">
            <input type="radio" id="w-option" name="year" tabindex="5" value="2023">
            <span>2023</span>
        </label>
    </div>

</div>
<div id="charts-container"></div>
</div>

<br> <br> <br>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.0/slimselect.min.js" integrity="sha512-mG8eLOuzKowvifd2czChe3LabGrcIU8naD1b9FUVe4+gzvtyzSy+5AafrHR57rHB+msrHlWsFaEYtumxkC90rg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var facultySelect = new SlimSelect({
        select: "#faculty"
    });

    // Изменяем текст placeholder
    var searchInput = document.querySelector('.ss-search input');
    searchInput.placeholder = 'Поиск...';
</script>

<script>
    function handleFacultySelection() {
        var selectElement = document.getElementById('faculty');
        var facultyId = selectElement.value;
        var selectedYear = document.querySelector('input[name="year"]:checked').value;

        // AJAX запрос к серверу
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    createPieCharts(response);
                } else {
                    console.error('Ошибка при получении данных о статистике');
                }
            }
        };

        // Отправляем AJAX запрос на сервер для получения данных о статистике выбранного факультета и текущего года
        xhr.open('POST', 'get_data.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('facultyId=' + encodeURIComponent(facultyId) + '&year=' + encodeURIComponent(selectedYear));
    }

    var facultySelect = document.getElementById('faculty');
    facultySelect.addEventListener('change', handleFacultySelection);

    function createPieCharts(data) {
        var chartsContainer = document.getElementById('charts-container');
        chartsContainer.innerHTML = '';

        data.forEach(function(item, index) {
            var chartId = 'chart-' + index;
            var chartAndLabelContainer = document.createElement('div');
            chartAndLabelContainer.classList.add('chart-and-label-container'); // Добавляем класс для нового контейнера
            chartAndLabelContainer.style.textAlign = 'center'; // Центрируем содержимое

            // Создаем элемент для надписи
            var labelElement = document.createElement('p');
            labelElement.classList.add('chart-label'); // Добавляем класс
            labelElement.textContent = item.subject_name;

            var canvasContainer = document.createElement('canvas');
            canvasContainer.id = chartId;
            canvasContainer.style.width = '400px'; // Устанавливаем ширину
            canvasContainer.style.height = '400px'; // Устанавливаем высоту
            chartAndLabelContainer.appendChild(labelElement); // Добавляем надпись в контейнер
            chartAndLabelContainer.appendChild(canvasContainer); // Добавляем диаграмму в контейнер
            chartsContainer.appendChild(chartAndLabelContainer);

            createChart(chartId, item, item.subject_name, item.min_grade); // Передаем минимальный балл вместо '0-60'
        });
    }

    // Функция для создания одной круговой диаграммы
    function createChart(chartId, data, subjectName, minGrade) {
        var ctx = document.getElementById(chartId).getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [minGrade + '-60', '60-80', '80-100'],
                datasets: [{
                    data: [data['0-60'], data['60-80'], data['80-100']],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: subjectName
                }
            }
        });
    }

    // Обработчик события для радиокнопок выбора года
    document.querySelectorAll('input[name="year"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var selectedYear = this.value;
            var facultySelect = document.getElementById('faculty');
            var facultyId = facultySelect.value;

            console.log('Отправка на сервер: Год - ' + selectedYear + ', Факультет ID - ' + facultyId);
            handleYearSelection(selectedYear, facultyId);
        });
    });

    // Функция для отправки данных на сервер и обработки ответа
    function handleYearSelection(selectedYear, facultyId) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    createPieCharts(response);
                } else {
                    console.error('Ошибка при получении данных о статистике');
                }
            }
        };

        xhr.open('POST', 'get_data.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('facultyId=' + encodeURIComponent(facultyId) + '&year=' + encodeURIComponent(selectedYear));
    }
</script>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://bootstraptema.ru/plugins/2016/shieldui/script.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>