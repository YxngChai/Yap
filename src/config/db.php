<?php
try {
$pdo = new \PDO('mysql:host=localhost;dbname=yap;charset=utf8', 'root', '',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
} catch (\PDOException $e) {
    die('Database connection failed: ' . $e ->getMessage());
}
?>