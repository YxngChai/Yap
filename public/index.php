<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/../src/controllers/authController.php';
    exit;

}

if(!isset($_SESSION['user_id'])){
    require __DIR__ . '/../src/controllers/authController.php';
    exit;
    }



require __DIR__ . '/../src/controllers/feedController.php';

