<?php 

require_once __DIR__ . '/../models/user.php';

$pdo = Database::getConnection();

$user = NULL;


if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $user = User::findById($pdo, $userId);

}

if (!$user) {
    echo'page not found';
    exit;

}


require __DIR__ . "/../../views/settings.php";