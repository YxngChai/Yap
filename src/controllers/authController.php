<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';

$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_POST['action'])  {
        case 'login':
            //check fields are filled
            if (empty($_POST['email']) || empty($_POST['password'])) {
            $error = "All fields are required";
            break;
            } 
            // trim email
            $email = trim($_POST['email']);
            //check email format is valid
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email address";
                break;
            }
            
            //check with db for user
            $user = User::findByEmail($pdo, $email);
            //assign to session if correct credentials
            if ($user && password_verify($_POST['password'], $user['password_hash'])){
                $_SESSION['user_id'] = $user['id'];

                header('Location: /yap/public/');
                exit;
            }
            //if incorrect credentials
            $error = "Incorrect login details";
            break; 
            
        case 'register':
            //register logic
            break;
        case 'logout':
            //logout
            session_unset();
            session_destroy();
            header('Location: /yap/public/');
            exit;
        
        
    }
}

require_once __DIR__ . '/../../views/auth.php';