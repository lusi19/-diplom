<?php
$questions = []; // Инициализация переменной $questions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Подключение к базе данных (замените значения на ваши)
    $servername = "localhost";
    $username = "root";
    $password = "gonedone24@L";
    $dbname = "diplom";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $categories = [
        "Человек-природа" => 0,
        "Человек-человек" => 0,
        "Человек-техника" => 0,
        "Человек-знаковая система" => 0,
        "Человек-художественный образ" => 0
    ];

    // Подсчет баллов для каждой категории
    foreach ($_POST as $answer) {
        if (array_key_exists($answer, $categories)) {
            $categories[$answer]++;
        }
    }

    // Общее количество вопросов
    $totalQuestions = count($_POST);

    // Расчет процентов
    foreach ($categories as $category => $score) {
        $categories[$category] = round(($score / $totalQuestions) * 100, 2);
    }

    $selectedCategories = [];
    $maxPercentage = max($categories);

    foreach ($categories as $category => $percentage) {
        if ($percentage >= 25) {
            $selectedCategories[] = $category;
        }
    }

    $sql = "SELECT quest, direction FROM test WHERE name_sphere IN ('" . implode("', '", $selectedCategories) . "')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = [
                'quest' => $row["quest"],
                'direction' => $row["direction"]
            ];
        }
    } else {
        echo "0 results";
    }

    $conn->close();
}
?>
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
    $buttonText = 'Выйти';
    $buttonLink = 'logout.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            display: none;
            /* Скрываем кнопку до выбора всех ответов */
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .question {
            display: none;
        }

        .question.active {
            display: block;
        }

        .completed {
            color: green;
        }

        .direction {
            font-weight: bold;
            color: #555;
            margin-top: 10px;
        }

        .excluded-directions {
            margin-top: 20px;
            font-weight: bold;
            color: red;
        }

        .remaining-directions {
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }

        .remaining-directions div {
            margin-bottom: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .direction-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .direction-container h2 {
            margin-top: 0;
        }

        .direction-container ul {
            list-style-type: none;
            padding-left: 20px;
        }

        .direction-container ul li {
            margin-bottom: 5px;
        }

        .progress {
            height: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: #007bff;
        }

        /* Стили для кнопки */
        .btn-primary {
            display: block;
            /* Делаем кнопку блочным элементом */
            margin: 20px auto 0;
            /* Устанавливаем отступ сверху и автоматически выравниваем по центру по горизонтали */
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Медиа-запрос для адаптации элементов на мобильных устройствах */
        @media only screen and (max-width: 600px) {
            .container {
                max-width: 90%;
                margin: 20px auto;
                padding: 10px;
            }

            .btn-primary {
                width: 80%;
                /* Устанавливаем ширину кнопки на мобильных устройствах */
                margin: 20px auto 0;
                /* Устанавливаем отступ сверху и автоматически выравниваем по центру по горизонтали */
            }
        }

        /* Медиа-запрос для адаптации элементов на планшетах */
        @media only screen and (min-width: 601px) and (max-width: 1024px) {
            .container {
                max-width: 80%;
            }
        }

        /* Медиа-запрос для адаптации элементов на устройствах с большим разрешением */
        @media only screen and (min-width: 1025px) {
            .container {
                max-width: 1200px;
            }
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
                    <li><a href="profile.php">Профиль</a></li>
                    <li><a href="ball_kal.php" class="active">Профоринтационный тест</a></li>
                    <a href="<?php echo $buttonLink; ?>" class="btn-getstarted"><?php echo $buttonText; ?></a>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>
    <div class="container">
        <h1>Тест для выбора направления подготовки</h1>
        <form id="testForm" method="post" action="">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($questions as $key => $questionData) {
                    $question = $questionData['quest'];
                    $direction = $questionData['direction'];
                    $class = $key === 0 ? 'active' : ''; // Делаем первый вопрос активным
                    echo "<div class='question $class' id='question$key' data-question-id='$key' data-direction='$direction'>";
                    echo "<label>$question</label>";
                    echo "<label><input type='radio' name='answer$key' value='Да'> Да</label>";
                    echo "<label><input type='radio' name='answer$key' value='Нет'> Нет</label>";
                    echo "</div>";
                }
            }
            ?>
        </form>
        <div class="progress">
            <div class="progress-bar" id="overallProgressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="remaining-directions" id="remainingDirections" style="display: none;">
            <div id="remainingList"></div>

        </div>

        <button id="checkAdmissionButton" style="display: none;">Проверить шанс поступления</button>
        <script>
            document.getElementById('checkAdmissionButton').addEventListener('click', function() {
                window.location.href = 'kalk.php'; // Замените 'result_page.php' на URL страницы, на которую вы хотите перенаправить пользователя
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentQuestion = 0;
                const totalQuestions = <?php echo count($questions); ?>;
                const form = document.getElementById('testForm');
                const directionCounts = {}; // Инициализация объекта для подсчета ответов по направлениям
                const excludedDirections = new Set();
                const allDirections = new Set();
                document.querySelectorAll('.question').forEach(question => {
                    allDirections.add(question.getAttribute('data-direction'));
                });

                function hideQuestionsByDirection(direction) {
                    document.querySelectorAll('.question').forEach(question => {
                        if (question.getAttribute('data-direction') === direction) {
                            question.style.display = 'none';
                        }
                    });
                    excludedDirections.add(direction);
                    showNextAvailableQuestion(); // Показываем следующий доступный вопрос
                    console.log('Исключенное направление:', direction); // Выводим исключенное направление в консоль
                }

                function showNextAvailableQuestion() {
                    while (currentQuestion < totalQuestions) {
                        const nextQuestion = document.getElementById('question' + currentQuestion);
                        if (nextQuestion && !excludedDirections.has(nextQuestion.getAttribute('data-direction'))) {
                            nextQuestion.classList.add('active');
                            return;
                        }
                        currentQuestion++;
                    }
                    // Показываем кнопку "Проверить шанс поступления" после ответа на все вопросы
                    if (currentQuestion >= totalQuestions) {
                        document.getElementById('checkAdmissionButton').style.display = 'block';
                        document.getElementById('overallProgressBar').style.width = '100%';
                    }

                    // После завершения всех вопросов вызываем функцию обновления списка оставшихся направлений
                    updateRemainingDirectionsList();
                }

                function updateRemainingDirectionsList() {
                    let remainingDirections = [];
                    allDirections.forEach(direction => {
                        if (!excludedDirections.has(direction)) {
                            remainingDirections.push(direction);
                        }
                    });

                    // Очищаем контейнер с оставшимися направлениями
                    const remainingDirectionsContainer = document.getElementById('remainingDirections');
                    remainingDirectionsContainer.innerHTML = '';

                    // Для каждого оставшегося направления создаем отдельный контейнер
                    remainingDirections.forEach(direction => {
                        const directionContainer = document.createElement('div');
                        directionContainer.classList.add('direction-container');
                        directionContainer.innerHTML = ` <h2>${direction}</h2> <ul>  <li>${direction}</li> </ul>`;
                        remainingDirectionsContainer.appendChild(directionContainer);
                    });

                    // Показываем контейнер с оставшимися направлениями
                    remainingDirectionsContainer.style.display = 'block';

                    // Показываем кнопку перехода на страницу kalk.php
                    const checkAdmissionButton = document.getElementById('checkAdmissionButton');
                    checkAdmissionButton.style.display = 'block';

                    // Добавляем обработчик события нажатия на кнопку
                    checkAdmissionButton.addEventListener('click', function() {
                        // Формируем строку из списка направлений для передачи в URL
                        const remainingDirectionsString = remainingDirections.join(',');
                        // Формируем URL с параметром remainingDirections
                        const url = 'kalk.php?remainingDirections=' + encodeURIComponent(remainingDirectionsString);
                        // Перенаправляем пользователя на страницу kalk.php с параметром URL
                        window.location.href = url;
                    });
                }

        


            function updateProgress() {
                if (currentQuestion >= totalQuestions) {
                    document.getElementById('overallProgressBar').style.width = '100%';
                } else {
                    const progress = (currentQuestion / totalQuestions) * 100;
                    document.getElementById('overallProgressBar').style.width = progress + '%';
                }
            }

            function checkAllNoAnswers() {
                const allNoAnswers = Object.values(directionCounts).every(count => count >= 4);
                const allQuestionsAnswered = currentQuestion >= totalQuestions;
                if (allNoAnswers && allQuestionsAnswered) {
                    const container = document.querySelector('.container');
                    container.innerHTML = '<h1>Результаты теста</h1>' + '<p>К сожалению не удалось определить направление для вас. Вы можете попробовать еще раз пройти тест.Удачи!' +
                        '<br>' + '<a href="ball_kal.php" class="btn btn-primary">Пройти тест еще раз</a>';
                }
            }

            document.querySelectorAll('.question input[type="radio"]').forEach(input => {
                input.addEventListener('change', function() {
                    const answer = this.value;
                    const direction = document.getElementById('question' + currentQuestion).getAttribute('data-direction');

                    if (answer === 'Нет') {
                        if (!directionCounts[direction]) {
                            directionCounts[direction] = 0;
                        }
                        directionCounts[direction]++;
                        if (directionCounts[direction] >= 4) {
                            hideQuestionsByDirection(direction);
                            checkAllNoAnswers(); // Добавляем проверку на ответы "Нет" после изменения ответа
                            return; // Добавляем return, чтобы прервать выполнение текущей функции
                        }
                    }

                    document.getElementById('question' + currentQuestion).classList.remove('active');
                    currentQuestion++;
                    showNextAvailableQuestion();
                    updateProgress(); // Обновляем прогресс теста после ответа на вопрос
                });
            });

            showNextAvailableQuestion(); // Показываем первый вопрос
            updateProgress(); // Обновляем прогресс теста при загрузке страницы
            });
        </script>
    </div>
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