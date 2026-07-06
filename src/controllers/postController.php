<?php

require_once __DIR__ . '/../models/post.php';

$pdo = Database::getConnection();

switch ($_POST['action']) {
    case 'create_post':
        Post::create($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'user_id' => $_SESSION['user']['id'],
        ]);
        header('Location: ' . ($_POST['redirect'] ?? '/yap/public/'));
        exit;

}