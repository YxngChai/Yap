<?php


require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../validators/validator.php';
require_once __DIR__ . '/../helpers/errors.php';

$pdo = Database::getConnection();

verifyCsrf();

$data = $_POST;
$_SESSION['old_post_content'] = $data['post_content'] ?? '';
$rules = ['post_content' => ['min' => 1, 'max' => 2000],];

switch ($_POST['action']) {

    case 'create_post':

        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            jsonError($errors);
            exit;
        }
        $filename = NULL;

        if(isset($_FILES['file'])){
            
            //verify    
            $result = Validator::validateImage(($_FILES['file']));

            if(!$result['success']) {
                jsonError($result['errors']);
                exit;
            }

            $extension = $result['extension'];
            $tmp= $_FILES['file']['tmp_name'];

            // save the file
            $filename = bin2hex(random_bytes(16)) . '.' . $extension;
                
            $path =  __DIR__ .'/../../public/assets/uploads/'.$filename;
                if (!move_uploaded_file($tmp,$path)) {
                    $errors[] = 'Failed to save the image';
                    jsonError($errors);
                    exit;
                }
        }

        $postId = Post::create($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => $filename,
            'user_id' => $_SESSION['user']['id'],
        ]);
        unset($_SESSION['old_post_content']);

            // redirectBack();
        $post = Post::findById($pdo, $postId, $_SESSION['user']['id']);
        
        $postRedirect =  $_POST['redirect'] ?? '/yap/public/';

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
        exit;


    case 'update_post':

        $errors = Validator::validatePost($data, $rules);
        if(!empty($errors)){
            jsonError($errors);
            exit;
        }

        $postId = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT);
        if ($postId === false || $postId < 1) {
            redirectBack();
            exit;
        }

        Post::update($pdo, [
            'content' => $_POST['post_content'],
            'image_path' => null,
            'id' => $postId,
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
        
    case 'remove picture':
        break;
}
