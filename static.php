<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .toggle-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            z-index: 9999;
            color: #fff;
            font-size: 30px;
        }

        .sidebar {
            position: fixed;
            height: 100%;
            width: 240px;
            background: #0A2558;
            transition: all 0.5s ease;
            margin-top: 0;
        }

        .sidebar.active {
            width: 60px;
        }

        .sidebar .nav-links {
            margin-top: 80px;
        }

        .sidebar .logo-details {
            display: none;
        }

        @media only screen and (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }

        @media only screen and (max-width: 480px) {
            .sidebar {
                width: 200px;
            }

            .sidebar.active {
                width: 100px;
            }
        }


        /* После вашего существующего CSS */
        .sidebar.active .nav-links li span {
            display: none;
        }

        .sidebar .nav-links li.active span {
            display: inline;
        }

        .container-wrapper {
            display: flex;
            flex-direction: row;
            margin-left: 17%;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-left: 20px;
            /* Добавляем отступ между контейнерами */
            max-width: 350px;
            flex: 1;
            /* Равномерно распределяем доступное пространство между контейнерами */
        }

        .user-icon {
            color: #333;
            font-size: 24px;
            margin-right: 10px;
        }

        .eye-icon {
            color: #333;
            font-size: 24px;
            margin-right: 10px;
        }

        .online-icon {
            color: green;
            /* Цвет иконки онлайна */
            font-size: 24px;
            margin-right: 10px;
        }

        h1 {
            font-size: 24px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class='bx bx-menu'></i>
        </div>
        <ul class="nav-links">
            <li>
                <a href="adminpanel.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Мероприятия</span>
                </a>
            </li>
            <li>
                <a href="send_letter.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Рассылки</span>
                </a>
            </li>
            <li>
                <a href="static.php" class="active">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">Статистика</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Пользователи</span>
                </a>
            </li>
            <li>
                <a href="messenger.php">
                    <i class='bx bx-message'></i>
                    <span class="links_name">Сообщения</span>
                </a>
            </li>

            <li class="log_out">
                <a href="logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>

        </ul>
    </div>
    <br>


    <?php
    // Подключение к базе данных
    $servername = "localhost";
    $username = "root"; // Замените на свои данные
    $password = "gonedone24@L";
    $dbname = "diplom"; // Замените на свои данные

    // Создание соединения
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL-запрос для получения количества пользователей
    $sql = "SELECT COUNT(*) AS user_count FROM users WHERE role <> 1";
    $result = $conn->query($sql);

    $user_count = 0; // Переменная для хранения количества пользователей

    // Если запрос выполнен успешно и есть результаты
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_count = $row["user_count"];
    }
    $current_date = date('Y-m-d');

    // Получаем общее количество посещений
    $counter_file = 'total_visits_' . $current_date . '.txt';
    if (file_exists($counter_file)) {
        $total_visits = (int) file_get_contents($counter_file);
    } else {
        $total_visits = 0;
    }

    // Получаем количество пользователей онлайн
    $sql = "SELECT COUNT(*) AS online_users FROM users WHERE last_activity_time > NOW() - INTERVAL 5 MINUTE"; // Предположим, что пользователь считается онлайн, если его последняя активность была менее 5 минут назад
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $online_users = $row["online_users"];
    } else {
        $online_users = 0;
    }
    $conn->close();
    ?>

    <div class="container-wrapper">
        <div class="container">
            <h1><i class="user-icon bx bx-user"></i> Пользователи</h1>
            <p>Количество зарегистрированных пользователей: <?php echo $user_count; ?></p>
        </div>
        <div class="container">
            <h1><i class="eye-icon bx bx-show"></i> Активность</h1>
            <p>Количество посещений сайта: <?php echo $total_visits; ?></p>
        </div>
        <div class="container">
            <h1><i class="bx bxs-like bx-tada-hover"></i> Пользователи онлайн</h1>
            <p>Количество пользователей онлайн: <?php echo $online_users; ?></p>
        </div>

    </div>

    </script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector(".sidebar");
            const sidebarBtn = document.querySelector(".toggle-btn");
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.innerHTML = '<i class="bx bx-menu-alt-right"></i>';
            } else {
                sidebarBtn.innerHTML = '<i class="bx bx-menu"></i>';
            }
        }
    </script>

</body>

</html>
