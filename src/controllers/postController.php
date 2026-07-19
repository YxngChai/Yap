<?php

use Soap\Url;

require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../validators/validator.php';

$pdo = Database::getConnection();

verifyCsrf();

$data = $_POST;

switch ($_POST['action']) {
    case 'create_post':

        $rules = [
            'post_content' => ['min' => 1, 'max' => 1000],
        ];
        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $signUpError = implode(", ", $errors);
            var_dump($signUpError);
            break;
            
        }

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
}
