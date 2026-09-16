<?php 

require_once __DIR__ . '/../models/user.php';

$pdo = Database::getConnection();

$user = NULL;


if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $user = User::findById($pdo, $userId);
    echo 'test';
    var_dump($user);
}

if (!$user) {
    echo'page not found';
    exit;

}

