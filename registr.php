<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="css/registerstyle.css">
    <style>
        input[title]::before {
            content: attr(title);
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 5px;
            position: absolute;
            top: calc(100% + 5px);
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            z-index: 1000;
            display: none;
        }

        input:hover[title]::before {
            display: block;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
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
            max-width: 400px;
            border-radius: 5px;
            text-align: center;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .ok-button {
            background-color: #2A4480;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .ok-button:hover {
            background-color: #0E2353;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="inner">
            <div class="image-holder">
                <img src="images/dgtu2.jpg" alt="">
            </div>
            <form action="" method="POST" onsubmit="return checkForm()">
                <h3>Регистрация</h3>
                <div class="form-wrapper">
                    <input type="text" name="first_name" placeholder="Имя" class="form-control" title="Данные должны состоять только из букв и не содержать пробелы" pattern="[A-Za-zА-Яа-яЁё]+" required data-error="">
                </div>
                <div class="form-wrapper">
                    <input type="text" name="last_name" placeholder="Фамилия" class="form-control" title="Данные должны состоять только из букв и не содержать пробелы" pattern="[A-Za-zА-Яа-яЁё]+" required data-error="">
                </div>
                <div class="form-wrapper">
                    <input type="text" name="username" placeholder="Никнейм" class="form-control" title="Данные должны состоять из латинских букв и цифр и не содержать пробелы" pattern="[A-Za-z0-9]+" required data-error="">
                </div>
                <div class="form-wrapper">
                    <input type="email" name="email" placeholder="Адрес почты" class="form-control" title="Введите адрес почты" required>
                </div>
                <div class="form-wrapper">
                    <select name="gender" class="form-control" title="Выберите пол" required data-error="">
                        <option value="" disabled selected>Выберите пол</option>
                        <option value="Мужской">Мужской</option>
                        <option value="Женский">Женский</option>
                    </select>
                </div>
                <div class="form-wrapper">
                    <input type="password" name="password" placeholder="Введите пароль" class="form-control" title="Пароль должен содержать минимум 8 символов, включая хотя бы одну заглавную букву, одну цифру и один специальный символ" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" required data-error="">
                </div>
                <div class="form-wrapper">
                    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" class="form-control" title="Пароли не совпадают" required oninput="checkPasswordMatch(this)" data-error="">
                </div>
                <div class="button-wrapper">
                    <button type="submit">Зарегистрироваться</button>
                </div>
                <div class="login-link">
                    <a href="signUp.php">Есть аккаунт? Войти</a>
                </div>
            </form>
        </div>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle"></h2>
            <p id="modalMessage"></p>
            <button class="ok-button" onclick="closeModal()">ОК</button>
        </div>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "gonedone24@L";
    $dbname = "diplom";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $user_username = $_POST["username"]; // Используем другое имя переменной, чтобы не затереть значение
        $user_email = $_POST["email"]; // Используем другое имя переменной, чтобы не затереть значение
        $gender = $_POST["gender"];
        $password = $_POST["password"];

        // Проверка существования учетной записи с такой почтой
        $email_check_query = "SELECT * FROM users WHERE email='$user_email' LIMIT 1"; // Используем правильное имя переменной
        $result = mysqli_query($conn, $email_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            // Если учетная запись существует, выводим модальное окно с предупреждением
            echo "<script>
                document.getElementById('modal').style.display = 'block';
                document.getElementById('modalMessage').innerText = 'Учетная запись с такой почтой уже существует. Попробуйте использовать другую почту или авторизуйтесь.';
              </script>";
        } else {
            // Если учетной записи с такой почтой нет, добавляем данные в базу данных
            $first_name = mysqli_real_escape_string($conn, $first_name);
            $last_name = mysqli_real_escape_string($conn, $last_name);
            $user_username = mysqli_real_escape_string($conn, $user_username); // Используем другое имя переменной, чтобы не затереть значение
            $user_email = mysqli_real_escape_string($conn, $user_email); // Используем другое имя переменной, чтобы не затереть значение
            $gender = mysqli_real_escape_string($conn, $gender);
            $password = mysqli_real_escape_string($conn, $password);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (first_name, last_name, username, email, gender, password) 
            VALUES ('$first_name', '$last_name', '$user_username', '$user_email', '$gender', '$hashed_password')"; // Используем правильные переменные
            if ($conn->query($sql) === TRUE) {
                // Если данные успешно добавлены, выводим модальное окно об успешной регистрации
                echo "<script>
                    document.getElementById('modal').style.display = 'block';
                    document.getElementById('modalMessage').innerText = 'Регистрация прошла успешно! Ваша учетная запись была успешно создана.';
                  </script>";
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    }
    ?>

    <script>
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            window.location.href = "signUp.php";
        }

        function checkForm() {
            var isValid = true;
            var fields = document.querySelectorAll('[data-error]');
            fields.forEach(function(field) {
                field.removeAttribute('data-error');
            });
            var firstName = document.getElementsByName("first_name")[0].value.trim();
            var lastName = document.getElementsByName("last_name")[0].value.trim();
            var username = document.getElementsByName("username")[0].value.trim();
            var gender = document.getElementsByName("gender")[0].value.trim();
            var password = document.getElementsByName("password")[0].value.trim();
            var confirmPassword = document.getElementsByName("confirm_password")[0].value.trim();
            if (firstName === "" || lastName === "" || username === "" || gender === "" || password === "" || confirmPassword === "") {
                document.getElementsByName("first_name")[0].setAttribute('data-error', 'Введите все необходимые данные');
                isValid = false;
            }
            if (firstName.match(/^\s+$/) || lastName.match(/^\s+$/) || username.match(/^\s+$/)) {
                document.getElementsByName("first_name")[0].setAttribute('data-error', 'Введите корректные значения');
                isValid = false;
            }
            if (gender === "") {
                document.getElementsByName("gender")[0].setAttribute('data-error', 'Выберите пол');
                isValid = false;
            }
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password)) {
                document.getElementsByName("password")[0].setAttribute('data-error', 'Пароль должен содержать минимум 8 символов, включая хотя бы одну заглавную букву, одну цифру и один специальный символ');
                isValid = false;
            }
            if (password !== confirmPassword) {
                document.getElementsByName("confirm_password")[0].setAttribute('data-error', 'Пароли не совпадают');
                isValid = false;
            }
            return isValid;
        }

        function checkPasswordMatch(inputField) {
            var password = document.getElementsByName("password")[0].value.trim();
            var confirmPassword = inputField.value.trim();
            if (password !== confirmPassword) {
                inputField.setCustomValidity("Пароли не совпадают");
            } else {
                inputField.setCustomValidity("");
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById('modal');

            // Открытие модального окна
            function openModal() {
                modal.style.display = 'block';
            }

            // Закрытие модального окна
            function closeModal() {
                modal.style.display = 'none';
            }

            // Обработчик события клика на кнопку "ОК"
            var okButton = document.querySelector('.ok-button');
            okButton.addEventListener('click', function() {
                closeModal();
            });

            // Обработчик события клика на весь документ
            document.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>

</html>