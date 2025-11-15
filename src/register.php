<?php
require_once "db.php";

// Получаем данные из POST
$username = $_POST['user'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Проверка, что все поля заполнены
if (empty($username) || empty($email) || empty($password)) {
    echo "error: Пожалуйста, заполните все поля";
    exit;
}

// Валидация: email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "error: Некорректный email";
    exit;
}

// Валидация: пароль минимум 8 символов
if (strlen($password) < 8) {
    echo "error: Пароль должен быть не менее 8 символов";
    exit;
}

// Проверка, есть ли уже такой пользователь
$stmt = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "error: Пользователь с таким именем или email уже существует";
    $stmt->close();
    exit;
}
$stmt->close();

// Хешируем пароль
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Вставка нового пользователя
$stmt = $conn->prepare("INSERT INTO users (username, email, password, score) VALUES (?, ?, ?, 0)");
$stmt->bind_param("sss", $username, $email, $hashed_password);

if ($stmt->execute()) {
    echo "ok: Пользователь зарегистрирован";
} else {
    echo "error: Не удалось зарегистрировать пользователя";
}

$stmt->close();
$conn->close();
?>
