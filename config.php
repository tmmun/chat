<?php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tmmun');

// Пример использования констант
$host = DB_HOST;
$username = DB_USERNAME;
$dbpassword = DB_PASSWORD;
$dbname = DB_NAME;

// Создание подключения к базе данных
$conn = new mysqli($host, $username, $dbpassword, $dbname);

// Проверка соединения на ошибки
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

?>