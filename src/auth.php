<?php
require_once "db.php";

// Получаем данные
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("error:Пожалуйста, заполните все поля");
}

// Подготавливаем запрос (PostgreSQL)
$query = "SELECT username, password_hash, score FROM users WHERE email = $1";
$result = pg_query_params($conn, $query, [$email]);

if (!$result) {
    die("error:Ошибка подготовки запроса");
}

// Проверяем, найден ли пользователь
if (pg_num_rows($result) > 0) {

    $row = pg_fetch_assoc($result);

    $username = $row["username"];
    $hash     = $row["password_hash"];
    $score    = $row["score"];

    // Проверяем пароль
    if (password_verify($password, $hash)) {
        echo "ok:Авторизация успешна:$username:$score";
    } else {
        echo "error:Неверный пароль";
    }

} else {
    echo "error:Пользователь не найден";
}

pg_close($conn);
?>
