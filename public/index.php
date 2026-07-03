<?php

session_start();

    
$action = $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

if(!isset($_SESSION['user'])){
    require __DIR__ . '/../src/controllers/authController.php';
    exit;
    }


if ($method === 'POST') {


    if (in_array($action, ['signin', 'signup', 'logout'])) {
        require __DIR__ . '/../src/controllers/authController.php';
        exit;
    }

    if (in_array($action, ['create_post', 'delete_post'])) {
        require __DIR__ . '/../src/controllers/feedController.php';
        exit;
    }

    if (in_array($action, ['create_comment', 'delete_comment'])) {
        require __DIR__ . '/../src/controllers/commentController.php';
        exit;
    }


}

require __DIR__ . '/../src/controllers/feedController.php';

