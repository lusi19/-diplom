<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "gonedone24@L";
$dbname = "diplom";

// Получение параметра facultyId из POST запроса
$facultyId = $_POST['facultyId'];
// Получение параметра year из POST запроса
$year = $_POST['year'];

// Создание подключения к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запрос к базе данных для получения статистики для каждого предмета на выбранном факультете
$sql = "SELECT 
            subquery.subject_id,
            subjects.name AS subject_name,
            subjects.min$year AS min_grade,
            COUNT(CASE WHEN subquery.grade >= 0 AND subquery.grade < 60 THEN 1 END) AS '0-60',
            COUNT(CASE WHEN subquery.grade >= 60 AND subquery.grade < 80 THEN 1 END) AS '60-80',
            COUNT(CASE WHEN subquery.grade >= 80 AND subquery.grade <= 100 THEN 1 END) AS '80-100'
        FROM (
                SELECT subject1_id AS subject_id, subject1_grade AS grade FROM students_results WHERE faculty_id = $facultyId AND year = $year
                UNION ALL
                SELECT subject2_id AS subject_id, subject2_grade AS grade FROM students_results WHERE faculty_id = $facultyId AND year = $year
                UNION ALL
                SELECT subject3_id AS subject_id, subject3_grade AS grade FROM students_results WHERE faculty_id = $facultyId AND year = $year
                UNION ALL
                SELECT subject4_id AS subject_id, subject4_grade AS grade FROM students_results WHERE faculty_id = $facultyId AND year = $year AND subject4_id IS NOT NULL AND subject4_grade IS NOT NULL
            ) AS subquery
        LEFT JOIN subjects ON subquery.subject_id = subjects.id
        GROUP BY subquery.subject_id";

// Выполнение запроса к базе данных
$result = $conn->query($sql);

// Инициализация массива для хранения данных о статистике для каждого предмета
$data = array();

// Обработка результатов запроса
if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Добавление данных о статистике для текущего предмета в массив
        $data[] = array(
            'subject_id' => $row['subject_id'],
            'subject_name' => $row['subject_name'],
            'min_grade' => $row['min_grade'],
            '0-60' => $row['0-60'],
            '60-80' => $row['60-80'],
            '80-100' => $row['80-100']
        );
    }
} else {
    // Ошибка при выполнении запроса
    $data['error'] = 'Ошибка при получении данных';
}

// Возвращаем данные в формате JSON
echo json_encode($data);

// Закрытие подключения к базе данных
$conn->close();
?>
