<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Пользователи</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .container {
            max-width: 1050px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 2%;
        }

        /* После вашего существующего CSS */
        .sidebar.active .nav-links li span {
            display: none;
        }

        .sidebar .nav-links li.active span {
            display: inline;
        }

        /* Новый стиль для поля поиска */
        .search-container {
            right: 10px;
            top: 10px;
            display: flex;
            align-items: center;
            background-color: #f2f2f2;
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

        .gender-select-wrapper {
            position: relative;
            display: block;
        }

        .gender-select-arrow {
            position: absolute;
            right: 20px;
            bottom: 6px;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #757575;
            cursor: pointer;
        }

        .gender-options {
            position: absolute;
            top: calc(50% + 5px);
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            min-width: 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
            list-style: none;
            padding: 5px;
        }


        .gender-options li {
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        .gender-options label {
            display: block;
            margin-bottom: 5px;
            cursor: pointer;
            margin: 0;

        }

        .gender-options input[type="checkbox"] {
            margin-right: 5px;
        }

        .status-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .status-select-arrow {
            position: absolute;
            bottom: 0px;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #757575;
            cursor: pointer;
        }

        .status-options {
            position: absolute;
            top: calc(100% + 5px);
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            min-width: 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
            list-style: none;
            padding: 5px;
        }

        .status-options li {
            margin-right: 30px;
            display: flex;
            align-items: center;
        }

        .status-options a {
            display: block;
            text-decoration: none;
            color: #000;
            cursor: pointer;
        }

        .status-options a:hover {
            background-color: #f2f2f2;
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
                <a href="static.php">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">Статистика</span>
                </a>
            </li>
            <li>
                <a href="users.php" class="active">
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
    <br>
    <br>
    <div class="container table">
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Поиск">
            <button><i class='bx bx-search'></i></button>

        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Адрес почты</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Никнейм</th>
                    <th>Пол
                        <div class="gender-select-wrapper">
                            <div class="gender-select-arrow" onclick="toggleGenderOptions()"></div>
                            <ul class="gender-options">
                                <li>
                                    <input type="checkbox" id="maleGender" onchange="filterByGender(this)">
                                    <label for="maleGender">Мужской</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="femaleGender" onchange="filterByGender(this)">
                                    <label for="femaleGender">Женский</label>
                                </li>
                            </ul>
                        </div>
                    </th>

                    <th>
                        Статус
                        <div class="status-select-wrapper">
                            <div class="status-select-arrow" onclick="toggleStatusOptions()"></div>
                            <ul class="status-options">
                                <li>
                                    <input type="checkbox" id="onlineStatus" onchange="setStatus(this)">
                                    <label for="onlineStatus">Онлайн</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="offlineStatus" onchange="setStatus(this)">
                                    <label for="offlineStatus">Офлайн</label>
                                </li>
                            </ul>
                        </div>
                    </th>

                </tr>
            </thead>
            <tbody>
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

                // Запрос к базе данных
                $sql = "SELECT id, email, first_name, last_name, username, gender, last_activity_time FROM users WHERE role <> 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>"; // Выводим id сообщения
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["gender"] . "</td>";
                        echo "<td>" . $row["last_activity_time"] . "</td>"; // Выводим время последнего посещения
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Нет данных</td></tr>";
                };
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
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

        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector("table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                var found = false; // Флаг для обнаружения совпадений в любом столбце
                // Проверяем каждую ячейку в текущей строке
                for (var j = 0; j < tr[i].cells.length; j++) {
                    td = tr[i].cells[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true; // Если найдено совпадение в любом столбце, устанавливаем флаг в true
                            break; // Прерываем внутренний цикл, так как нет необходимости проверять другие столбцы
                        }
                    }
                }
                // Если найдено совпадение в любом столбце, отображаем строку, иначе скрываем
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        function filterByGender(checkbox) {
            var selectedGender = checkbox.id;
            var isChecked = checkbox.checked;
            var rows = document.querySelectorAll("table tbody tr");

            // Фильтруем строки таблицы, если хотя бы один чекбокс выбран
            if (isChecked) {
                rows.forEach(function(row) {
                    var genderCell = row.querySelector("td:nth-child(6)");
                    var gender = genderCell.textContent.toUpperCase();
                    if ((selectedGender === "maleGender" && gender === "МУЖСКОЙ") || (selectedGender === "femaleGender" && gender === "ЖЕНСКИЙ")) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            } else {
                // Если ни один чекбокс не выбран, отображаем все строки
                rows.forEach(function(row) {
                    row.style.display = "";
                });
            }
        }

        function toggleGenderOptions() {
            var genderOptions = document.querySelector('.gender-options');
            // Если список скрыт, показываем его, иначе скрываем
            if (genderOptions.style.display === 'none' || genderOptions.style.display === '') {
                genderOptions.style.display = 'block';
            } else {
                genderOptions.style.display = 'none';
            }
        }




        function updateStatus() {
            console.log("Updating user status...");
            var rows = document.querySelectorAll("table tbody tr");
            var currentTime = new Date().getTime(); // Получаем текущее время в миллисекундах

            rows.forEach(function(row) {
                var lastActivityCell = row.querySelector("td:nth-child(7)"); // Получаем ячейку с временем последней активности
                console.log("Last activity cell content:", lastActivityCell.textContent);
                var lastActivityTime = new Date(lastActivityCell.textContent).getTime(); // Преобразуем время из строки в миллисекунды
                console.log("Last activity time:", lastActivityTime);

                // Разница между текущим временем и временем последней активности в минутах
                var differenceInMinutes = Math.floor((currentTime - lastActivityTime) / (1000 * 60)); // Округляем до целого числа
                console.log("Difference in minutes:", differenceInMinutes);

                // Устанавливаем значение статуса
                if (differenceInMinutes <= 1) {
                    row.querySelector("td:nth-child(7)").textContent = "Онлайн";
                } else {
                    row.querySelector("td:nth-child(7)").textContent = "Офлайн";
                }
            });
        }


        // Вызываем функцию обновления статуса каждые 5 минут
        setInterval(updateStatus, 5 * 60 * 1000); // 5 * 60 * 1000 миллисекунд = 5 минут
        updateStatus();

        function toggleStatusOptions() {
            var statusOptions = document.querySelector('.status-options');
            // Если список скрыт, показываем его, иначе скрываем
            if (statusOptions.style.display === 'none' || statusOptions.style.display === '') {
                statusOptions.style.display = 'block';
            } else {
                statusOptions.style.display = 'none';
            }
        }



        function setStatus(checkbox) {
            var selectedStatus = checkbox.id;
            var isChecked = checkbox.checked;
            var otherCheckboxId = selectedStatus === "onlineStatus" ? "offlineStatus" : "onlineStatus"; // Идентификатор другого чекбокса
            var otherCheckbox = document.getElementById(otherCheckboxId); // Получаем другой чекбокс

            // Если текущий чекбокс выбран, сбрасываем флажок другого чекбокса
            if (isChecked) {
                otherCheckbox.checked = false;
            }

            var rows = document.querySelectorAll("table tbody tr");

            // Фильтруем строки таблицы в зависимости от статуса
            if (isChecked) {
                rows.forEach(function(row) {
                    var statusCell = row.querySelector("td:nth-child(7)");
                    var status = statusCell.textContent.trim().toUpperCase(); // Убираем лишние пробелы и приводим к верхнему регистру
                    if ((selectedStatus === "onlineStatus" && status === "ОНЛАЙН") || (selectedStatus === "offlineStatus" && status === "ОФЛАЙН")) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            } else {
                // Если текущий чекбокс не выбран, отображаем все строки
                rows.forEach(function(row) {
                    row.style.display = "";
                });
            }
        }
    </script>