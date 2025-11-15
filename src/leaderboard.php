<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require 'db.php';

$sql = "SELECT username, score FROM users ORDER BY score DESC LIMIT 100";
$res = $conn->query($sql);

$rows = [];
while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>
