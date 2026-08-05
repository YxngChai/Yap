<?php


require_once __DIR__ . '/../models/post.php';


$pdo = Database::getConnection();
$post = Post::findById($pdo, $post_id, $_SESSION['user']['id']);


require __DIR__ . "/../../views/postDetails.php";