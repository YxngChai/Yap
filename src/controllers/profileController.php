<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/user.php';

$pdo = Database::getConnection();

$user = NULL;



if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $user = User::findByUsername($pdo, $username);
}

if (!$user) {
    require __DIR__ . '/../../views/userNotFound.php';
    exit;

}

$userPicture = User::getProfilePicturePath($user['profile_picture']);
$coverImage = User::getCoverImagePath($user['cover_picture']);

$isOwnProfile = $user['id'] === $_SESSION['user']['id'];

$posts = Post::findUserPosts($pdo, $user['id']);




require __DIR__ . "/../../views/profile.php";