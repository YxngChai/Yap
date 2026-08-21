<?php


require_once __DIR__ . '/../models/comment.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../validators/validator.php';

$pdo = Database::getConnection();

verifyCsrf();

$data = $_POST;
$_SESSION['old_comment_content'] = $data['comment_content'] ?? '';
$rules = ['comment_content' => ['min' => 1, 'max' => 2000],];



switch ($_POST['action']) {

    case 'create_comment':

        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $_SESSION['create_comment_errors'] = $errors;
            redirectBack();
        }
        $postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        if ($postId === false || $postId < 1) {
            $_SESSION['create_comment_errors'] = $postId;
            redirectBack();
        }

        if(!Post::findById($pdo, $postId,  $_SESSION['user']['id'])) {
            $_SESSION['create_comment_errors'] = 'Cannot find id';
            redirectBack();
        }

        $commentId = Comment::create($pdo, [
            'content' => $data['comment_content'],
            'image_path' => null,
            'user_id' => $_SESSION['user']['id'],
            'post_id' => $postId
        ]);
        unset($_SESSION['old_comment_content']);
            // redirectBack();
        $comment = Comment::findById($pdo, $commentId, $_SESSION['user']['id']);
        
        if (!$comment) {
            exit;
        }
        $redirect = $_POST['redirect'] ?? '/yap/public/';

        header('Content-Type: application/json');

        ob_start();

        require __DIR__ . '/../../views/partials/comment.php';

        $html = ob_get_clean();

        echo json_encode([
            'success' => true,
            'html' => $html
        ]);

        exit;

    case 'delete_comment':
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
        if ($commentId === false || $commentId < 1) {
        header('Location: /yap/public/');
        exit;
        }
        Comment::delete($pdo, $commentId, $_SESSION['user']['id']);
            redirectBack();

    case 'update_comment':

        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            $_SESSION['update_comment_errors'] = $errors;
            redirectBack();
        }
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
        if ($commentId === false || $commentId < 1) {
            redirectBack();
        }
        Comment::update($pdo, [
            'content' => $data['comment_content'],
            'image_path' => null,
            'id' => $commentId,
            'user_id' => $_SESSION['user']['id'],
        ]);

        unset($_SESSION['old_comment_content']);

        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'comment' => [
            'id' => $data['commentId'],
            'username' => $_SESSION['user']['username'],
            'content' => $data['comment_content'],
            ]
        ]);
        exit;
        // redirectBack();

        
    case 'remove_picture_comment':
        break;
}
