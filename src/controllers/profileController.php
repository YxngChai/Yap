<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/user.php';

$pdo = Database::getConnection();



$userId = $_GET['user_id'];
$isOwnProfile = $userId === $_SESSION['user']['id'];

$user = User::findById($pdo, $userId);



if (!$user) {
    require __DIR__ . '/../../views/userNotFound.php';
    exit;

}
$posts = Post::findUserPosts($pdo, $userId);

require __DIR__ . "/../../views/profile.php";