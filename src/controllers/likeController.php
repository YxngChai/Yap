<?php


require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();

$post = Post::findById($pdo, $_POST['postId']  , $_SESSION['user']['id']);

switch($_POST['action']) {
    case 'like_post':
        if ($post['liked']) {
            Post::unlikePost($pdo , $_SESSION['user']['id'], $post['id']);
        } else {
            Post::likePost($pdo ,  $_SESSION['user']['id'], $post['id']);
        }
        header('Location: ' . ($_POST['redirect'] ?? '/yap/public/'));
        exit;
    case 'like_comment':
        exit;
}