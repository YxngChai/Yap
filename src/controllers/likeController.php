<?php


require_once __DIR__ . '/../models/post.php';

verifyCsrf();

$pdo = Database::getConnection();

switch($_POST['action']) {
    
    case 'like_post':
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
        if ($postId === false || $postId < 1) {
            http_response_code(400);
            exit('Invalid post ID.');
        }
        $post = Post::findById($pdo, $postId, $_SESSION['user']['id']);

        if (!$post) {
            http_response_code(404);
            exit('Post not found.');
        }

        if ($post['liked']) {
            Post::unlikePost($pdo, $postId , $_SESSION['user']['id']);
        } else {
            Post::likePost($pdo, $postId ,  $_SESSION['user']['id']);
        }

        $postUpdated = Post::findById($pdo,  $postId, $_SESSION['user']['id']);
        header('Content-Type: application/json');

        echo json_encode([
            'liked' => $postUpdated['liked'],
            'likeCount' =>  $postUpdated['like_count'],
        ]);
        exit;

    case 'like_comment':
        exit;
}