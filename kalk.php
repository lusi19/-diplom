<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Подключение к базе данных
    $host = 'localhost';
    $db = 'diplom';
    $user = 'root';
    $pass = 'gonedone24@L';
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database connection failed']);
        exit();
    }

    // Получение данных из POST-запроса
    $data = json_decode(file_get_contents('php://input'), true);
    $subject1_id = $data['subject1_id'];
    $subject2_id = $data['subject2_id'];
    $subject3_id = $data['subject3_id'];
    $grade1 = $data['grade1'];
    $grade2 = $data['grade2'];
    $grade3 = $data['grade3'];

    $remainingDirectionsString = '';
    if (isset($_GET['remainingDirections'])) {
        $remainingDirectionsString = $_GET['remainingDirections'];
    }

    // Преобразование строки remainingDirectionsString в массив направлений
    $remainingDirections = explode(",", $remainingDirectionsString);

    // Подготовка SQL-запроса для получения данных о направлениях и требуемых предметах, учитывая только направления из remainingDirections
    $sql = "SELECT direction, subject1, subject2, subject3, total_grade
            FROM kalkulator
            WHERE direction IN ('" . implode("','", $remainingDirections) . "')";

    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Анализ данных
    $probabilities = [];
    $totalCounts = [];
    $userTotalGrade = $grade1 + $grade2 + $grade3;

    foreach ($results as $row) {
        $direction = $row['direction'];
        $required_subjects = [$row['subject1'], $row['subject2'], $row['subject3']];
        $total_grade = $row['total_grade'];

        if (!isset($probabilities[$direction])) {
            $probabilities[$direction] = 0;
            $totalCounts[$direction] = 0;
        }

        // Проверяем, подходят ли выбранные предметы для данного направления
        if (
            in_array($subject1_id, $required_subjects) &&
            in_array($subject2_id, $required_subjects) &&
            in_array($subject3_id, $required_subjects)
        ) {
            $totalCounts[$direction]++;
            if ($userTotalGrade >= $total_grade) {
                $probabilities[$direction]++;
            }
        }
    }

    // Вычисляем вероятности для каждого направления
    foreach ($probabilities as $direction => $count) {
        if ($totalCounts[$direction] > 0) {
            $probabilities[$direction] = round(($count / $totalCounts[$direction]) * 100, 2);
        } else {
            unset($probabilities[$direction]);
        }
    }

    // Сортировка вероятностей в порядке убывания
    arsort($probabilities);

    // Возвращение данных в формате JSON
    echo json_encode($probabilities);

    exit();
} else {
    // Подключение к базе данных для получения списка предметов
    $host = 'localhost';
    $db = 'diplom';
    $user = 'root';
    $pass = "gonedone24@L";
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Database connection failed';
        exit();
    }

    // Получение данных из GET-запроса
    $remainingDirectionsString = '';
    if (isset($_GET['remainingDirections'])) {
        $remainingDirectionsString = $_GET['remainingDirections'];
    }

    // Преобразование строки remainingDirectionsString в массив направлений
    $remainingDirections = explode(",", $remainingDirectionsString);

    // Получение списка предметов, которые подходят для выбранных направлений
    $sql = "SELECT DISTINCT s.id, s.name
        FROM subjects s
        JOIN kalkulator k ON s.id = k.subject1 OR s.id = k.subject2 OR s.id = k.subject3
        WHERE k.direction IN ('" . implode("','", $remainingDirections) . "')";

    $stmt = $pdo->query($sql);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

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
    $buttonText = 'Выход';
    $buttonLink = 'logout.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Калькулятор баллов</title>
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
</head>



<style>
    form {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        max-width: 90%;
        /* Максимальная ширина формы */
        margin-left: auto;
        /* Отступ слева */
        margin-right: auto;
        /* Отступ справа */
    }


    .faculty-container {
        border: 1px solid #ccc;
        padding: 10px;
        /* Добавляем внутренний отступ */
        width: calc(33.33% - 20px);
        /* Ширина контейнера будет 1/3 ширины родительского контейнера с учетом отступов */
        box-sizing: border-box;
        /* Учитываем ширину рамки при расчете ширины контейнера */
        display: inline-block;
        /* Делаем контейнеры строчно-блочными, чтобы они располагались в одну строку */
        margin: 10px;
        /* Внешний отступ между контейнерами */
        height: 200px;
        /* Устанавливаем фиксированную высоту */
        overflow: hidden;
    }

    label,
    input,
    select {
        display: block;
        margin-bottom: 10px;
    }

    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin: 0 auto;
        /* Центрирование кнопки */
        display: block;
        /* Превращаем кнопку в блочный элемент, чтобы установить ей ширину */
        width: fit-content;
        /* Устанавливаем ширину кнопки в соответствии с её содержимым */
    }


    button:hover {
        background-color: #0056b3;
    }

    #result {
        margin-top: 20px;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
    }

    #result h2 {
        margin-top: 0;
    }

    #result p {
        margin: 0;
    }

    /* CSS для мобильных устройств */
    @media (max-width: 768px) {
        form {
            max-width: 100%;
            /* Максимальная ширина формы на мобильных устройствах */
        }

        .faculty-container {
            width: calc(100% - 20px);
            /* Ширина контейнера на мобильных устройствах */
            margin: 10px 0;
            /* Внешний отступ между контейнерами на мобильных устройствах */
        }
    }

    /* CSS для планшетов */
    @media (min-width: 768px) and (max-width: 992px) {
        .faculty-container {
            width: calc(50% - 20px);
            /* Ширина контейнера на планшетах */
        }
    }

    /* CSS для настольных компьютеров */
    @media (min-width: 992px) {
        .faculty-container {
            width: calc(33.33% - 20px);
            /* Ширина контейнера на настольных компьютерах */
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
    <h1 style="text-align: center;">Рассчитать вероятность поступления</h1>
    <form id="admissionForm">
        <label for="subject1">Выберите первый предмет:</label>
        <select id="subject1" name="subject1_id" required>
            <option value="" disabled selected>Выберите предмет</option>
            <?php foreach ($subjects as $subject) : ?>
                <option value="<?= htmlspecialchars($subject['id']) ?>"><?= htmlspecialchars($subject['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="grade1">Введите балл по первому предмету:</label>
        <input type="number" id="grade1" name="grade1" required max="100" oninput="validity.valid||(value='');">

        <label for="subject2">Выберите второй предмет:</label>
        <select id="subject2" name="subject2_id" required>
            <option value="" disabled selected>Выберите предмет</option>
            <?php foreach ($subjects as $subject) : ?>
                <option value="<?= htmlspecialchars($subject['id']) ?>"><?= htmlspecialchars($subject['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="grade2">Введите балл по второму предмету:</label>
        <input type="number" id="grade2" name="grade2" required max="100" oninput="validity.valid||(value='');">

        <label for="subject3">Выберите третий предмет:</label>
        <select id="subject3" name="subject3_id" required>
            <option value="" disabled selected>Выберите предмет</option>
            <?php foreach ($subjects as $subject) : ?>
                <option value="<?= htmlspecialchars($subject['id']) ?>"><?= htmlspecialchars($subject['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="grade3">Введите балл по третьему предмету:</label>
        <input type="number" id="grade3" name="grade3" required max="100" oninput="validity.valid||(value='');">
        <button type="submit">Рассчитать вероятность</button>
    </form>

    <div id="result">

    </div>
    <script>
        document.getElementById('admissionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let subject1_id = document.getElementById('subject1').value;
            let grade1 = parseInt(document.getElementById('grade1').value);
            let subject2_id = document.getElementById('subject2').value;
            let grade2 = parseInt(document.getElementById('grade2').value);
            let subject3_id = document.getElementById('subject3').value;
            let grade3 = parseInt(document.getElementById('grade3').value);

            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        subject1_id: subject1_id,
                        grade1: grade1,
                        subject2_id: subject2_id,
                        grade2: grade2,
                        subject3_id: subject3_id,
                        grade3: grade3
                    })
                })
                .then(response => response.json())
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        subject1_id: subject1_id,
                        grade1: grade1,
                        subject2_id: subject2_id,
                        grade2: grade2,
                        subject3_id: subject3_id,
                        grade3: grade3
                    })
                })
                .then(response => response.json())
                .then(data => {
                    let resultDiv = document.getElementById('result');
                    resultDiv.innerHTML = ''; // Очищаем содержимое перед добавлением новых контейнеров
                    if (data.error) {
                        resultDiv.innerHTML += `<p>Ошибка: ${data.error}</p>`;
                    } else {
                        for (let faculty in data) {
                            let facultyContainer = document.createElement('div');
                            facultyContainer.classList.add('faculty-container'); // Добавляем класс faculty-container
                            // Создаем контейнеры для каждой записи
                            let facultyName = document.createElement('h3');
                            facultyName.textContent = faculty;
                            facultyContainer.appendChild(facultyName);
                            let facultyProbability = document.createElement('p');
                            facultyProbability.textContent = `Вероятность: ${data[faculty]}%`;
                            facultyContainer.appendChild(facultyProbability);
                            // Добавляем каждый созданный контейнер в общий контейнер результатов
                            resultDiv.appendChild(facultyContainer);
                        }
                    }
                })
                .catch(error => console.error('Ошибка:', error));

        });
        document.addEventListener("DOMContentLoaded", function() {
            // Следим за изменениями в списках выбора предметов
            const subject1Select = document.getElementById("subject1");
            const subject2Select = document.getElementById("subject2");
            const subject3Select = document.getElementById("subject3");

            subject1Select.addEventListener("change", function() {
                disableSelectedOption(subject1Select.value);
            });

            subject2Select.addEventListener("change", function() {
                disableSelectedOption(subject2Select.value);
            });

            subject3Select.addEventListener("change", function() {
                disableSelectedOption(subject3Select.value);
            });

            // Функция для отключения выбранного предмета в других списках выбора
            function disableSelectedOption(selectedValue) {
                const selects = [subject1Select, subject2Select, subject3Select];
                selects.forEach(select => {
                    Array.from(select.options).forEach(option => {
                        if (option.value === selectedValue) {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });
                });
            }
        });
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