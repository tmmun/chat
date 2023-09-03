<?php

// Получение значения из Ajax запроса
require_once 'config.php';

// Подключение к базе данных
$login = $_POST['login'];
$password = $_POST['password'];

// Подготовка и выполнение SQL-запроса
$sql = "SELECT * FROM `chatacc` WHERE `login` = ?";

$stmt = $conn->prepare($sql);

// Параметры для подготовленного выражения
$stmt->bind_param("s", $login);

// Выполнение запроса
$stmt->execute();

// Получение результата
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // Обработка данных
    $login = $row['login'];
    $pass_hash = $row['password'];
}

if (password_verify($password, $pass_hash)) {
    echo $login . '|Messages|' . $pass_hash;
} else {
    echo "Ошибка";
    //echo 'Пароль неправильный.';
}

// Закрытие подготовленного выражения
$stmt->close();

// Закрытие соединения с базой данных
$conn->close();
