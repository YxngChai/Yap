<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/comment.php';


$pdo = Database::getConnection();
$post = Post::findById($pdo, $post_id, $_SESSION['user']['id']);
if(!$post) {
    require __DIR__ . "/../../views/postNotFound.php";
    exit;
}
$comments = Comment::findPostComments($pdo, $post_id, $_SESSION['user']['id']);


require __DIR__ . "/../../views/postDetails.php";