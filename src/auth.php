<?php
require 'db.php';

$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

if (!$email || !$pass) { echo "error: fill all fields"; exit; }

$sql = "SELECT username, password, score FROM users WHERE email='$email'";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (password_verify($pass, $row['password']))
        echo "ok:auth:" . $row['username'] . ":" . $row['score'];
    else
        echo "error: wrong password";
} else {
    echo "error: user not found";
}
?>
