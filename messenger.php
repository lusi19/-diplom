<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Сообщения</title>
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

        /* После вашего существующего CSS */
        .sidebar.active .nav-links li span {
            display: none;
        }

        .sidebar .nav-links li.active span {
            display: inline;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 950px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10%;
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

        /* Стили для модального окна */
        .modal {
            display: none;
            /* По умолчанию модальное окно скрыто */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
            max-height: 300px;
            /* Максимальная высота контейнера */
            overflow-y: auto;
        }


        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .reply-button {
            background-color: #007bff;
            /* Синий цвет */
            color: #fff;
            /* Белый цвет текста */
            border: none;
            /* Убираем границу */
            border-radius: 20px;
            /* Закругляем углы */
            padding: 10px 20px;
            /* Задаем отступы */
            cursor: pointer;
            /* Делаем курсор указателем */
            transition: background-color 0.3s;
            /* Плавное изменение цвета при наведении */
        }

        .reply-button:hover {
            background-color: #0056b3;
            /* Цвет кнопки при наведении */
            cursor: pointer;
            /* Изменение курсора при наведении */
        }

        /* Стили для ссылки "Просмотреть" */
        a.view-message {
            cursor: pointer;
            /* Изменение курсора при наведении */
            color: #007bff;
            /* Цвет ссылки */
        }

        a.view-message:hover {
            color: #0056b3;
            /* Цвет ссылки при наведении */
        }

        /* Стили для формы ответа */
        #replyForm {
            margin-top: 20px;
        }

        #replyTextArea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
            /* Запретить изменение размера текстового поля */
        }

        .submit-button {
            background-color: #28a745;
            /* Зеленый цвет */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #218838;
            /* Зеленый цвет при наведении */
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
                <a href="users.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">Пользователи</span>
                </a>
            </li>
            <li>
                <a href="messenger.php" class="active">
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
                    <th>Тема</th>
                    <th>Дата отправки<span id="sortIcon" onclick="changeSortDirection()">&#x25B2;</span></th>
                    <th>Сообщения</th>

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
                $sql = "SELECT id,email, name, subject, created_at, message FROM feedback";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>"; // Выводим id сообщения
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["subject"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "<td><a class='view-message' onclick=\"openModal(this.getAttribute('data-message'), this.getAttribute('data-email'))\" data-message='" . htmlspecialchars($row["message"], ENT_QUOTES) . "' data-email='" . htmlspecialchars($row["email"], ENT_QUOTES) . "'>Просмотреть</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Нет данных</td></tr>";
                };
                $conn->close();

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;
                // Закрытие соединения с базой данных
                require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\Exception.php';
                require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\PHPMailer.php';
                require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\SMTP.php';
                // Проверка соединения
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }


                // Проверяем, была ли отправлена форма методом POST
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Получаем данные из формы
                    $toEmail = $_POST['email'];
                    $message = $_POST['message'];



                    $mail = new PHPMailer(true);
                    try {
                        // Отправка письма
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'lusinevar16@gmail.com';
                        $mail->Password = 'cawo zkyq mfmm dpej';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('lusinevar16@gmail.com');
                        $mail->addAddress($toEmail);

                        $mail->isHTML(true);
                        $mail->Subject = '=?utf-8?B?' . base64_encode('Ответ на ваше обращение') . '?=';
                        $mail->Body = $message;

                        $mail->send();
                        echo '<script>window.location.href = "messenger.php?success=true";</script>';

                    } catch (Exception $e) {
                        // Возвращаем сообщение об ошибке на клиентскую сторону
                        echo "error";
                    }
                }
                ?>


            </tbody>
        </table>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="messageContainer" class="message-container"></div>
            <br>
            <br>
            <button onclick="showReplyForm()" class="reply-button">Ответить</button>
            <br>
            <br>
            <form id="replyForm" style="display: none;" method="post" onsubmit="sendEmail(event)">
                <p id="replyEmail"> </p> <!-- Отображение адреса электронной почты -->
                <input type="hidden" name="email" id="hiddenReplyEmail"> <!-- Скрытое поле для передачи адреса электронной почты -->
                <textarea name="message" id="replyTextArea" rows="4" cols="50"></textarea>
                <br>
                <button type="submit" class="submit-button">Отправить</button>
            </form>

        </div>
    </div>
    <script>
        function openModal(message, email) {
            var modal = document.getElementById("myModal");
            var messageContainer = document.getElementById("messageContainer");
            var replyEmail = document.getElementById("replyEmail");
            var hiddenReplyEmail = document.getElementById("hiddenReplyEmail");

            // Очистим содержимое контейнера перед добавлением нового контента
            messageContainer.innerHTML = "";

            // Создадим новый элемент для каждой строки сообщения и добавим его в контейнер
            var lines = message.split('\\n');
            lines.forEach(function(line) {
                var paragraph = document.createElement("p");
                paragraph.textContent = line;
                messageContainer.appendChild(paragraph);
            });

            // Установим значение поля почты получателя
            replyEmail.textContent = "Email получателя: " + email;
            hiddenReplyEmail.value = email; // Установка значения скрытого поля для передачи в форму ответа

            modal.style.display = "block";
        }


        function showReplyForm() {
            var replyForm = document.getElementById("replyForm");
            replyForm.style.display = "block"; // Показываем форму
        }


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
        var ascending = true;

        function changeSortDirection() {
            var sortIcon = document.getElementById("sortIcon");
            ascending = !ascending;
            if (ascending) {
                sortIcon.innerHTML = "&#x25B2;"; // Стрелка вверх
            } else {
                sortIcon.innerHTML = "&#x25BC;"; // Стрелка вниз
            }
            sortTable();
        }

        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.querySelector("table");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[4]; // Индекс столбца с датой (начиная с 0)
                    y = rows[i + 1].getElementsByTagName("TD")[4];
                    if (ascending) {
                        if (new Date(x.innerHTML) > new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (new Date(x.innerHTML) < new Date(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
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
    </script>
    <script>
        // Закрыть модальное окно
        // Закрыть модальное окно и форму ответа
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
            closeReplyForm(); // Закрыть форму ответа
        }

        // Закрыть форму ответа
        function closeReplyForm() {
            var replyForm = document.getElementById("replyForm");
            replyForm.style.display = "none"; // Скрыть форму ответа
        }


        // Закрыть модальное окно при щелчке вне его области
        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
                closeReplyForm();
            }
        }
    </script>

    </script>


</body>

</html>