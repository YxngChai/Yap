<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../validators/validator.php';

$pdo = Database::getConnection();

verifyCsrf();

$data = $_POST;
$_SESSION['old_post_content'] = $data['post_content'] ?? '';

switch ($_POST['action']) {

    case 'create_post':

        $rules = [
            'post_content' => ['min' => 1, 'max' => 2000],
        ];
        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $_SESSION['create_errors'] = $errors;
            redirectBack();
        }

        $postId = Post::create($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'user_id' => $_SESSION['user']['id'],
        ]);
        unset($_SESSION['old_post_content']);
            // redirectBack();
        $post = Post::findById($pdo, $postId, $_SESSION['user']['id']);
        
        header('Content-Type: application/json');

        ob_start();

        require __DIR__ . '/../../views/partials/post.php';

        $html = ob_get_clean();

        echo json_encode([
            'success' => true,
            'html' => $html
        ]);

        exit;

    case 'delete_post':
        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
        if ($postId === false || $postId < 1) {
        header('Location: /yap/public/');
        exit;
        }
        Post::delete($pdo, $postId, $_SESSION['user']['id']);
            redirectBack();


    case 'update_post':
        $rules = [
            'post_content' => ['min' => 1, 'max' => 2000],
        ];
        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $_SESSION['update_errors'] = $errors;
            redirectBack();
        }
        Post::update($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'id' => $_POST['postId'],
            'user_id' => $_SESSION['user']['id'],
        ]);

        unset($_SESSION['old_post_content']);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'post' => [
                'id' => $_POST['postId'],
                'username' => $_SESSION['user']['username'],
                'content' => $_POST['post_content'],
            ]
        ]);
        exit;
        // redirectBack();

        
    case 'remove picture':
        break;
}
