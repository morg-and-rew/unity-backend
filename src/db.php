<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = "dpg-d4c7lujipnbc7399d5sg-a.oregon-postgres.render.com";
$port = "5432";
$dbname = "unity_game_db";
$user = "unity_game_db_user";
$pass = "Pi42aI0IZISZ5ASqVN36mpUll2zfRNzf";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("error:Ошибка подключения к базе");
}
?>
