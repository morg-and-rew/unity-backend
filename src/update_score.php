<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require 'db.php';

$username = $_POST['username'] ?? '';
$score = $_POST['score'] ?? '';

if (!$username || !$score) { echo "error: empty fields"; exit; }

$sql = "SELECT score FROM users WHERE username='$username'";
$r = $conn->query($sql);

if ($r->num_rows > 0) {
    $row = $r->fetch_assoc();
    if ((int)$score > (int)$row['score']) {
        $update = "UPDATE users SET score='$score' WHERE username='$username'";
        if ($conn->query($update)) echo "success: updated";
        else echo "error: cannot update";
    } else echo "ok: no change";
} else echo "error: user not found";
?>
