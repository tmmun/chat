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
    $result = mysqli_query($conn, $sql);

    $response = [];

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $response['success'] = true;
        $response['data'] = $data;
    } else {
        $response['success'] = false;
    }

    // Отправка ответа в формате JSON
    echo json_encode($response);
}

function ver($conn, $title)
{
    // Подготовка и выполнение SQL-запроса
    $sql = "SELECT * FROM `chatacc` WHERE `login` = '$title'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Обработка полученных данных, например, вывод или использование в других операциях
        while ($row = $result->fetch_assoc()) {
            $pass_hash = $row['password'];
            // ... другие поля
        }
    } else {
        echo "Ошибка";
    }

    return $pass_hash;
}

mysqli_close($conn);
