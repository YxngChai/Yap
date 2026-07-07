<?php

require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();

verifyCsrf();

switch ($_POST['action']) {
    case 'create_post':
        Post::create($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'user_id' => $_SESSION['user']['id'],
        ]);
        header('Location: ' . ($_POST['redirect'] ?? '/yap/public/'));
    case 'delete_post':
            // header('Location: /yap/public/');
        exit;
    case 'remove picture':
        break;
    case 'update_post':
        exit;
        exit;

}