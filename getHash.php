<?php

$title = $_POST['title'];

$options = [
    'cost' => 12,
];

echo password_hash($title, PASSWORD_BCRYPT, $options);

?>
