<?php
require_once "db.php";

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "error: Заполните все поля";
    exit;
}

// Ищем пользователя по email
$stmt = $conn->prepare("SELECT username, password, score FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username, $hashed_password, $score);

if ($stmt->num_rows === 0) {
    echo "error: Пользователь не найден";
    $stmt->close();
    exit;
}

$stmt->fetch();

// Проверяем пароль
if (password_verify($password, $hashed_password)) {
    echo "ok: Авторизация успешна:$email:$username:$score";
} else {
    echo "error: Неверный пароль";
}

$stmt->close();
$conn->close();
?>
