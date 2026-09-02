<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/user.php';

$pdo = Database::getConnection();

$user = NULL;
$profilePicture = NULL;



if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $user = User::findByUsername($pdo, $username);
}

if (!$user) {
    require __DIR__ . '/../../views/userNotFound.php';
    exit;

}
if (!$user['profile_picture']) {
    $profilePicture = '/yap/public/assets/images/profile_anonymous.jpeg';
} else {
$profilePicture = '/yap/public/assets/uploads/' . $user['profile_picture'];
}

$isOwnProfile = $user['id'] === $_SESSION['user']['id'];

$posts = Post::findUserPosts($pdo, $user['id']);




require __DIR__ . "/../../views/profile.php";