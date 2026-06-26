<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';

$error = null;
$old = $_POST;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_POST['action'])  {
        case 'signin':
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
            
        case 'signup':
            //check fields are filled
            $required = ['username','name','surname','birth_date','email','password','password_verification'];
            $missing = [];

            foreach($required as $field){
                if(!isset($_POST[$field]) || trim($_POST[$field]) == '') {
                    $missing[] = $field;
                }
            }
            if (!empty($missing)){
                $error = "Missing fields: ". implode(", ", $missing);
                break;
            }

            $email = $_POST['email'];
            $username = $_POST['username'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email address";
                break;
            }
            // check in db if username or email are already present
            $userEmail = User::findByEmail($pdo, $email);
            $userUsername = User::findByUsername($pdo, $username);
            if ($userEmail) {
                $error = 'Email already in use';
                break;
            }
            if ($userUsername) {
                $error = 'Username already in use';
                break;
            }
            //check length is ok

            //check passwords are identical

            // register in database
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