<?php

use Soap\Url;

require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../validators/validator.php';

$pdo = Database::getConnection();

verifyCsrf();

$data = $_POST;
$_SESSION['old_post_content'] = $data['post_content'];

switch ($_POST['action']) {
    case 'create_post':

        $rules = [
            'post_content' => ['min' => 1, 'max' => 2000],
        ];
        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
            echo "empty";
            header('Location: ' . ($_POST['redirect'] ?? '/yap/public/'));
            var_dump($signUpError);
            break;
            
        }

        Post::create($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'user_id' => $_SESSION['user']['id'],
        ]);
        unset($_SESSION['old_post_content']);
        header('Location: ' . ($_POST['redirect'] ?? '/yap/public/'));
        exit;
    case 'delete_post':
            // header('Location: /yap/public/');
        exit;
    case 'remove picture':
        break;
    case 'update_post':
        exit;
}
