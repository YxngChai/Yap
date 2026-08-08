<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax'
]);

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../src/helpers/csrf.php';
require_once __DIR__ . '/../src/helpers/redirect.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once __DIR__ . '/../src/config/db.php';
    
$action = $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$commentExpand = false;

// var_dump($uri);

if(!isset($_SESSION['user'])){
    require __DIR__ . '/../src/controllers/authController.php';
    exit;
    }

if ($method === 'GET') { 
        if (preg_match('#^/yap/public/user/([a-zA-Z0-9_]+)$#', $uri, $matches)) {
        // for other user's profile
            $_GET['username'] = (string) $matches[1];
            require __DIR__ . '/../src/controllers/profileController.php';
            exit;
        }
        // for own profile
        if (preg_match('#^/yap/public/user/?$#', $uri)) {
            $_GET['user_id'] = $_SESSION['user']['id'];
            require __DIR__ . '/../src/controllers/profileController.php';
            exit;
        }
        if (preg_match('#^/yap/public/p/([0-9]+)$#', $uri, $matches)) {
            $post_id = (string) $matches[1];
            require __DIR__ . '/../src/controllers/showPostController.php';
            exit;
        }
    require __DIR__ . '/../src/controllers/feedController.php';
    exit;
}



if ($method === 'POST') {

// var_dump($action);

    if (in_array($action, ['signin', 'signup', 'logout'])) {
        require __DIR__ . '/../src/controllers/authController.php';
        exit;
    }

    if (in_array($action, ['create_post', 'delete_post', 'update_post'])) {
        require __DIR__ . '/../src/controllers/postController.php';
        exit;
    }

    if (in_array($action, ['like_post', 'like_comment'])){
        require __DIR__ . '/../src/controllers/likeController.php';
    }


    if (in_array($action, ['create_comment', 'delete_comment', 'update_comment'])) {
        require __DIR__ . '/../src/controllers/commentController.php';
        exit;
    }


}

// require __DIR__ . '/../src/controllers/feedController.php';

