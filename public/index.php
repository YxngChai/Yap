<?php


session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once __DIR__ . '/../src/config/db.php';
    
$action = $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// var_dump($uri);

if(!isset($_SESSION['user'])){
    require __DIR__ . '/../src/controllers/authController.php';
    exit;
    }

if ($method === 'GET') { 
        if (preg_match('#^/yap/public/profile/(\d+)$#', $uri, $matches)) {
        // for other user's profile
        $_GET['user_id'] = (int) $matches[1];
        require __DIR__ . '/../src/controllers/profileController.php';
        exit;
        }
        // for own profile
        if (preg_match('#^/yap/public/profile/?$#', $uri)) {
        $_GET['user_id'] = $_SESSION['user']['id'];
        require __DIR__ . '/../src/controllers/profileController.php';
        exit;
        }
    require __DIR__ . '/../src/controllers/feedController.php';
    exit;
}



if ($method === 'POST') {

var_dump($action);
    if (in_array($action, ['signin', 'signup', 'logout'])) {
        require __DIR__ . '/../src/controllers/authController.php';
        exit;
    }


    if (in_array($action, ['create_post', 'delete_post'])) {
        require __DIR__ . '/../src/controllers/postController.php';
        exit;

    }


    if (in_array($action, ['create_comment', 'delete_comment'])) {
        require __DIR__ . '/../src/controllers/commentController.php';
        exit;
    }


}

// require __DIR__ . '/../src/controllers/feedController.php';

