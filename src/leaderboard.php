<?php
require 'db.php';

$sql = "SELECT username, score FROM users ORDER BY score DESC LIMIT 100";
$res = $conn->query($sql);

$rows = [];
while ($row = $res->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>
