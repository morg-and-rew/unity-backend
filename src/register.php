<?php
header('Content-Type: application/json');

// Получаем данные из POST
$username = $_POST['user'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Пожалуйста, заполните все поля"]);
    exit;
}

// Подключение к PostgreSQL через переменные окружения
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 5432;
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Ошибка подключения к базе"]);
    exit;
}

// Проверка на существующего пользователя
$result = pg_query_params($conn, "SELECT id FROM users WHERE username=$1 OR email=$2", [$username, $email]);
if (!$result) {
    echo json_encode(["status" => "error", "message" => "Ошибка запроса к базе"]);
    exit;
}

if (pg_num_rows($result) > 0) {
    echo json_encode(["status" => "error", "message" => "Пользователь с таким именем или почтой уже существует"]);
    exit;
}

// Хэшируем пароль
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Вставляем нового пользователя
$insert = pg_query_params($conn, "INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3)", [$username, $email, $passwordHash]);
if ($insert) {
    echo json_encode(["status" => "ok", "message" => "Регистрация успешна!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Ошибка регистрации"]);
}

pg_close($conn);
?>
