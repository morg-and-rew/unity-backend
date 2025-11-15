CREATE DATABASE IF NOT EXISTS unity_db;
USE unity_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255),
    score INT DEFAULT 0
);
