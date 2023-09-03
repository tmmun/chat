<?php

// Подключение к базе данных
require_once 'config.php';

$title = $_POST['title'];
$tableName = $_POST['table_name'];
$login = $_POST['login'];
$password = ver($conn, $title);

if (password_verify($login, $password)) {

    // Выполнение запроса к базе данных для получения данных из таблицы
    $sql = "SELECT * FROM " . $tableName;

    //Подготовьте SQL-запрос с использованием подготовленных выражений для безопасной обработки пользовательского ввода.
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Ошибка подготовки SQL-запроса: ' . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    //Извлеките данные из результата и сохраните их в массиве.
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    //Используйте функцию json_encode() для преобразования массива в формат JSON.
    $jsonData = json_encode($data);
    echo $jsonData;
}

function ver($conn, $title)
{
    // Подготовка и выполнение SQL-запроса
    $sql = "SELECT * FROM `chatacc` WHERE `login` = ?";

    $stmt = $conn->prepare($sql);

    // Параметры для подготовленного выражения
    $stmt->bind_param("s", $title);

    // Выполнение запроса
    $stmt->execute();

    // Получение результата
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Обработка данных
        $pass_hash = $row['password'];
    }

    return $pass_hash;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
