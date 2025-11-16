<?php
header('Content-Type: application/json');

// Получение данных
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Пожалуйста, заполните все поля"]);
    exit;
}

// Получение переменных окружения Render
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 5432;
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');

// Подключение к PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Ошибка подключения к базе"]);
    exit;
}

// Получение пользователя по email
$query = "SELECT username, password_hash, score FROM users WHERE email = $1";
$result = pg_query_params($conn, $query, [$email]);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "Ошибка выполнения запроса"]);
    exit;
}

if (pg_num_rows($result) === 0) {
    echo json_encode(["status" => "error", "message" => "Пользователь не найден"]);
    exit;
}

$row = pg_fetch_assoc($result);

// Проверка пароля
if (!password_verify($password, $row['password_hash'])) {
    echo json_encode(["status" => "error", "message" => "Неверный пароль"]);
    exit;
}

// Всё ок — возвращаем данные
echo json_encode([
    "status" => "ok",
    "message" => "Авторизация успешна",
    "username" => $row['username'],
    "score" => (int)$row['score']
]);

pg_close($conn);
?>
