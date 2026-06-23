<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';

$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

switch ($_POST['action'])  {
    case 'login':
        $user = User::findByEmail($pdo, $_POST['email']);
        if ($user && password_verify($_POST['password'], $user['password_hash'])){
            $_SESSION['user_id'] = $user['id'];

            header('Location: /yap/public/');
            exit;
        }
        $error = "Incorrect login details";
        break;
        
    case 'register':
        //login logic
        break;
    
}
}

require_once __DIR__ . '/../../views/auth.php';




// $user = User::findByEmail($pdo, 'babyyoda@gmail.com');

// if (!$user ){
//     echo "NO user";
// } else {
//     echo "Welcome";
// }