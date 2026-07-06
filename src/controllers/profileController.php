<?php


require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();



$posts = Post::findUserPosts($pdo, $_SESSION['user']['id']);

require __DIR__ . "/../../views/profile.php";