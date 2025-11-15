<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// Используем данные Render Managed Database
$host = "dpg-d4c7lujipnbc7399d5sg-a";  // сюда Render даёт хост
$user = "unity_game_db_user";              // имя пользователя Render
$pass = "Pi42aI0IZISZ5ASqVN36mpUll2zfRNzf";          // пароль
$db   = "unity_game_db";                 // имя базы

$conn = new mysqli($host, $user, $pass, $db);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка соединения с базой: " . $conn->connect_error);
}

// Установим кодировку UTF-8
$conn->set_charset("utf8");
?>
