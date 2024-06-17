<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рассылка</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="css/admin.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 96%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        option {
            padding: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

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

        .sidebar.active .nav-links li span {
            display: none;
        }

        .sidebar .nav-links li.active span {
            display: inline;
        }

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
                <a href="send_letter.php" class="active">
                    <i class='bx bx-list-ul'></i>
                    <span class="links_name">Рассылка</span>
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
    <div class="container">
        <h2>Отправить письмо</h2>
        <form method="post" id="emailForm">
            <label for="subject">Тема:</label>
            <input type="text" id="subject" name="subject" required>
            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" rows="6" required></textarea>
            <label>Выберите получателей:</label>
            <select name="recipients[]" multiple id="selectRecipients" style="width: 100%;">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "gonedone24@L";
                $dbname = "diplom";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, email FROM subscribe";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["email"] . '">' . $row["email"] . '</option>';
                    }
                }

                $conn->close();
                ?>
            </select>
            <br>
            <br>
            <br>
            <button type="button" onclick="selectAll()">Отметить все</button>
            <button type="submit" name="send_email">Отправить</button>
        </form>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"></p>
        </div>
        <?php

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\Exception.php';
        require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\PHPMailer.php';
        require 'C:\OSPanel\domains\localhost\vendor\phpmailer\phpmailer\src\SMTP.php';

        if (isset($_POST['send_email'])) {
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $recipients = $_POST['recipients'];

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'lusinevar16@gmail.com';
                $mail->Password = 'cawo zkyq mfmm dpej';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('lusinevar16@gmail.com');
                $mail->addReplyTo('lusinevar16@gmail.com');
                foreach ($recipients as $recipient) {
                    $mail->addAddress($recipient);
                }

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8'; // Установка кодировки на UTF-8
                $mail->Subject = $subject;

                $mail->Body = $message;

                $mail->send();
                echo '<script>window.location.href = "send_letter.php?success=true";</script>';
            } catch (Exception $e) {
                echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
            }
        }
        ?>
    </div>

    <script>
        $(document).ready(function() {
            // Проверяем, было ли показано модальное окно после успешной отправки письма
            var modalShown = <?php echo isset($_GET['success']) && $_GET['success'] == 'true' ? 'true' : 'false'; ?>;
            if (modalShown) {
                openModal("Письмо успешно отправлено");
                // Удаляем параметр success из URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // ...Остальной JavaScript код здесь...


            // Скрываем модальное окно при обновлении страницы, если success не был передан в URL
            if (!modalShown) {
                closeModal();
            }
            $('#selectRecipients').select2({
                placeholder: 'Выберите получателей',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return 'Ничего не найдено';
                    }
                }
            });

            // Обработчик события для закрытия модального окна при нажатии на крестик
            $('.close').click(function() {
                closeModal();
            });

            // Обработчик события для закрытия модального окна при клике вне области модального окна
            $(window).click(function(event) {
                if (event.target == document.getElementById('myModal')) {
                    closeModal();
                }
            });

            // Обработчик события для закрытия модального окна при обновлении страницы
            $(window).on('beforeunload', function() {
                if (modalShown) {
                    closeModal();
                }
            });
        });

        function selectAll() {
            $('#selectRecipients').val($('#selectRecipients option').map(function() {
                return $(this).val();
            }).get()).trigger('change');
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

        function openModal(message) {
            document.getElementById("modalMessage").innerText = message;
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>


</body>

</html>