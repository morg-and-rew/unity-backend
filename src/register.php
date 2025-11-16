<?php
header("Content-Type: text/plain; charset=utf-8");
require_once "db.php";

// Получаем данные из POST
$username = $_POST['user'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Проверка на пустые поля
if (empty($username) || empty($email) || empty($password)) {
    die("error:Пожалуйста, заполните все поля");
}

// Проверяем, есть ли такой пользователь
$checkQuery = "SELECT id FROM users WHERE username=$1 OR email=$2";
$checkResult = pg_query_params($conn, $checkQuery, [$username, $email]);

if (!$checkResult) {
    die("error:Ошибка запроса к базе");
}

if (pg_num_rows($checkResult) > 0) {
    die("error:Пользователь с таким именем или почтой уже существует");
}

// Хэшируем пароль
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Добавляем пользователя
$insertQuery = "INSERT INTO users (username, email, password_hash, score) VALUES ($1, $2, $3, 0)";
$insertResult = pg_query_params($conn, $insertQuery, [$username, $email, $passwordHash]);

if (!$insertResult) {
    die("error:Ошибка регистрации");
}

echo "ok:Регистрация успешна!";
pg_close($conn);
?>
