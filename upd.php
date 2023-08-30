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
    $sql = "INSERT INTO `Messages` (`id`, `title`, `content`) VALUES (NULL, '$title', '$content')";

    // запрос к базе данных
    $result2 = mysqli_query($conn, $sql);

    if ($result2) {
        echo ver($conn, $title);
    } else {
        // Обработка ошибки выполнения запроса
        echo " | Ошибка выполнения запроса: |" . mysqli_error($conn);
    }
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

// Закрытие соединения с базой данных
mysqli_close($conn);

//