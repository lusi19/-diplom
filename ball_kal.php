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
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);

        }

        .question {
            display: none;
        }

        .question.active {
            display: block;
        }

        .answers {
            list-style-type: none;
            padding: 0;
        }

        .answers li {
            background-color: #f4f4f4;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .answers li:hover {
            background-color: #ddd;
        }

        .submit-btn {
            display: none;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #54A591;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .progressi-container {
            margin-top: 20px;
        }

        .progressi {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .progressi li {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }

        .progressi li.completed {
            background-color: #54A591;
            color: white;
        }

        @media (max-width: 600px) {
            .progress {
                flex-wrap: wrap;
            }

            .progressi li {
                margin-bottom: 10px;
            }
        }

        .progressi-info {
            font-size: 14px;
            text-align: center;
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

    <title>Тест по выбору сферы деятельности</title>

    </head>

    <body>
        <br>
        <br>
        <div class="container">
            <h1>Тест по выбору сферы деятельности</h1>
            <form id="testForm" action="bal_kal1.php" method="post">

                <div class="question active" id="q1">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-природа">Ухаживать за животными</li>
                        <li data-answer="Человек-техника">Обслуживать машины, приборы</li>
                    </ul>
                </div>
                <div class="question" id="q2">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-человек">Помогать больным людям</li>
                        <li data-answer="Человек-техника">Составлять таблицы, схемы, программны вычислительных машин</li>
                    </ul>
                </div>
                <div class="question" id="q3">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-художественный образ">Следить за качеством книжных иллюстраций, плакатов, художественных открыток</li>
                        <li data-answer="Человек-природа">Следить за состоянием, развитием растений</li>
                    </ul>
                </div>
                <div class="question" id="q4">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-техника">Обрабатывать материалы (дерево, ткань, металл, пластмассу)</li>
                        <li data-answer="Человек-знаковая система">Доводить товары до потребителя (рекламировать, продавать)</li>
                    </ul>
                </div>
                <div class="question" id="q5">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-техника">Обсуждать научно популярные книги, статьи</li>
                        <li data-answer="Человек-художественный образ">Обсуждать художественные книги</li>
                    </ul>
                </div>
                <div class="question" id="q6">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-природа">Выращивать молодняк животных какой-либо породы</li>
                        <li data-answer="Человек-знаковая система">Тренировать сверстников (или младших) в выполнении каких-либо действий (трудовых, учебных, спортивных)</li>
                    </ul>
                </div>
                <div class="question" id="q7">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-художественный образ">Копировать рисунки, изобрадения, настраивать музыкальные инструменты</li>
                        <li data-answer="Человек-техника">Управлять каким-либо грузовым, подъемным транспортным средством (подъемным краном, трактором, тепловозом и др.)</li>
                    </ul>
                </div>
                <div class="question" id="q8">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-человек"> Сообщать, разъяснять людям нужные им сведения (в справочном бюро, на экскурсии и т.п.)</li>
                        <li data-answer="Человек-художественный образ">Художественно оформлять выставки, витрины, участвовать в подготовке пьес, концертов</li>
                    </ul>
                </div>
                <div class="question" id="q9">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-техника">Ремонтировать изделия, вещи (одежду, технику), жилище</li>
                        <li data-answer="Человек-знаковая система">Искать и исправлять ошибки в текстах, таблицах, рисунках</li>
                    </ul>
                </div>
                <div class="question" id="q10">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-природа">Лечить животных</li>
                        <li data-answer="Человек-знаковая система">Выполнять вычисления, расчеты</li>
                    </ul>
                </div>
                <div class="question" id="q11">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-природа">Выводить новые сорта растений</li>
                        <li data-answer="Человек-техника">Конструировать, проектировать новые виды промышленных изделий (машины, одежду, дома, продукты питания)</li>
                    </ul>
                </div>
                <div class="question" id="q12">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-человек">Разбирать споры, ссоры между людьми, убеждать, разъяснять, поощерять, наказывать</li>
                        <li data-answer="Человек-знаковая система">Разбираться в чертежах, схемах, таблицах (проверять, уточнять, приводить в порядок)</li>
                    </ul>
                </div>
                <div class="question" id="q13">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-художественный образ">Наблюдать, изучать работу кружков художественной самодеятельности</li>
                        <li data-answer="Человек-природа">Наблюдать, изучать жизнь микробов</li>
                    </ul>
                </div>
                <div class="question" id="q14">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-техника">Обслуживать, налаживать медицинские приборы и аппараты</li>
                        <li data-answer="Человек-человек">Оказывать людям медицинскую помощь при ранениях, ушибах, ожогах и т.п.</li>
                    </ul>
                </div>
                <div class="question" id="q15">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-знаковая система">Составлять точные описания (отчеты) о наблюдаемых явлениях, событиях, измеряемых объектах</li>
                        <li data-answer="Человек-художественный образ">Художественно описывать, изображать события, наблюдаемые или представляемые</li>
                    </ul>
                </div>
                <div class="question" id="q16">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-человек">Делать лабораторные анализы в больнице</li>
                        <li data-answer="Человек-художественный образ">Принимать, осматривать больных, беседовать с ними, назначать лечение</li>
                    </ul>
                </div>
                <div class="question" id="q17">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-художественный образ">Красить или расписывать стены помещений, поверхность изделий </li>
                        <li data-answer="Человек-техника">Осуществлять монтаж здания или сборку машин, приборов</li>
                    </ul>
                </div>
                <div class="question" id="q18">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-человек">Организовывать культпоходы сверстников или младших товарищей в театры, музеи, на экскурсии, в туристические походы и т.п.</li>
                        <li data-answer="Человек-художественный образ">Играть на сцене, принимать участие в концертах</li>
                    </ul>
                </div>
                <div class="question" id="q19">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-техника">Изготовлять по чертежам детали изделия (машины, одежду), строить здания</li>
                        <li data-answer="Человек-знаковая система">Заниматься черчением, копировать чертежи, карты</li>
                    </ul>
                </div>
                <div class="question" id="q20">
                    <p>Какую работу вы предпочтёте?</p>
                    <ul class="answers">
                        <li data-answer="Человек-природа">Вести борьбу с болезнями растений, с вредителями леса, сада</li>
                        <li data-answer="Человек-художественный образ">Работать на клавишных машинах (пишущей машинке, телетайпе, наборной машине и др.)</li>
                    </ul>
                </div>

                <!-- Добавьте остальные вопросы в аналогичном формате -->
                <input type="submit" value="Отправить" class="submit-btn" id="submitBtn">
               
            </form>
            <div class="progress-container">
                <p class="progress-info" id="progressInfo">Вы ответили на 0 вопросов из 20</p>
                <ul class="progressi" id="progressBar">
                    <!-- Прогресс-бары будут генерироваться динамически -->
                </ul>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentQuestion = 1;
                const totalQuestions = 20; // Увеличьте это число в соответствии с общим количеством вопросов
                const form = document.getElementById('testForm');
                const submitBtn = document.getElementById('submitBtn');
                const progressBar = document.getElementById('progressBar');
                const progressInfo = document.getElementById('progressInfo');

                // Генерация прогресс-бара
                for (let i = 1; i <= totalQuestions; i++) {
                    const progressItem = document.createElement('li');
                    progressItem.textContent = i;
                    progressBar.appendChild(progressItem);
                }

                function updateProgress() {
                    progressInfo.textContent = `Вы ответили на ${currentQuestion - 1} вопросов из ${totalQuestions}`;
                }

                document.querySelectorAll('.answers li').forEach(li => {
                    li.addEventListener('click', function() {
                        const answer = this.getAttribute('data-answer');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'q' + currentQuestion;
                        input.value = answer;
                        form.appendChild(input);

                        document.getElementById('q' + currentQuestion).classList.remove('active');
                        currentQuestion++;

                        if (currentQuestion <= totalQuestions) {
                            document.getElementById('q' + currentQuestion).classList.add('active');
                        } else {
                            submitBtn.style.display = 'block';
                        }

                        // Обновление прогресс-бара и информации
                        progressBar.children[currentQuestion - 2].classList.add('completed');
                        updateProgress();
                    });
                });

                // Инициализация прогресс-бара
                updateProgress();
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