<?php
require 'db.php';

$user = $_POST['user'] ?? '';
$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

if (!$user || !$email || !$pass) { echo "error: fill all fields"; exit; }

$hash = password_hash($pass, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hash')";
if ($conn->query($sql) === TRUE)
    echo "ok: registered";
else
    echo "error: user exists";
?>
