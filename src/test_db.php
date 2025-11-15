<?php
// Используем данные Render Managed Database
$host = "dpg-d4c7lujipnbc7399d5sg-a";  // сюда Render даёт хост
$user = "unity_game_db_user";              // имя пользователя Render
$pass = "Pi42aI0IZISZ5ASqVN36mpUll2zfRNzf";          // пароль
$db   = "unity_game_db";                 // имя базы

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
} else {
    echo "✅ Подключение к базе успешно!";
}
?>
