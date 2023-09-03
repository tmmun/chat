<?php

// Подключение к базе данных
require_once 'config.php';

// Получение значения из Ajax запроса
$title = $_POST['title'];
$content = $_POST['content'];
$login = $_POST['login'];
$password = ver($conn, $title);

if (password_verify($login, $password)) {
    // добавляем значения в таблицу
    $sql = "INSERT INTO `Messages` (`id`, `title`, `content`) VALUES (NULL, ?, ?)";

    // Подготовьте SQL-запрос с использованием подготовленных выражений для безопасной обработки пользовательского ввода.
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Ошибка подготовки SQL-запроса: ' . mysqli_error($conn));
    }

    // Свяжите значения параметров с подготовленными выражениями и выполните запрос.
    mysqli_stmt_bind_param($stmt, "ss", $title, $content);

    mysqli_stmt_execute($stmt);

    $affectedRows = mysqli_stmt_affected_rows($stmt);

    if ($affectedRows > 0) {
        echo "Данные успешно добавлены";
    } else {
        echo "Ошибка при добавлении данных";
    }
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

// Закрытие соединения с базой данных
mysqli_close($conn);

//