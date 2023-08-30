<?php

// Получение значения из Ajax запроса
require_once 'config.php';

// Подключение к базе данных
$login = $_POST['login'];
$password = $_POST['password'];

// Подготовка и выполнение SQL-запроса
$sql = "SELECT * FROM `chatacc` WHERE `login` = '$login'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Обработка полученных данных, например, вывод или использование в других операциях
    while ($row = $result->fetch_assoc()) {
        $login = $row['login'];
        $pass_hash = $row['password'];
        // ... другие поля
    }

    // верификация пароля
    if (password_verify($password, $pass_hash)) {
        echo $login . '|Messages|' . $pass_hash;
    } else {
        echo "Ошибка";
        //echo 'Пароль неправильный.';
    }
} else {
    echo "Ошибка";
}

// Закрытие соединения с базой данных
$conn->close();
