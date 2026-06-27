<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../validators/validator.php';

$error = null;
$old = $_POST;
$data = $_POST;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_POST['action'])  {
        case 'signin':
            //check fields are filled
            if (empty($data['email']) || empty($data['password'])) {
            $error = "All fields are required";
            break;
            } 
            // trim email
            $email = trim($data['email']);
            //check email format is valid
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error = "Invalid email address";
                break;
            }
            //check with db for user
            $user = User::findByEmail($pdo, $email);
            //assign to session if correct credentials
            if ($user && password_verify($data['password'], $user['password_hash'])){
                $_SESSION['user_id'] = $user['id'];

                header('Location: /yap/public/');
                exit;
            }
            //if incorrect credentials
            $error = "Incorrect login details";
            break; 
            
        case 'signup':
            //verify attributes are respected
            $rules = [
                'username' => ['required' => true, 'min' => 4, 'max' => 50],
                'name' => ['required' => true, 'min' => 2, 'max' => 50],
                'surname' => ['required' => true, 'min' => 2, 'max' => 100],
                'email' => ['required' => true, 'max' => 100, 'email' => true],
                'password' => ['required' => true, 'min' => 8, 'max' => 72],
                'password_verification' => ['required' => true],
            ];
            $errors = Validator::validate($data, $rules);
            if (!empty($errors)){
                $error = implode(", ", $errors);
                break;
            }
            // check in db if username or email are already present
            $email = strtolower(trim($data['email']));
            $username = trim($data['username']);

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
            //check passwords are identical
            if($data['password'] !== $data['password_verification']) {
                $error = "passwords do not matching";
                break;
            }
            // register in database
            $userId = User::create($pdo, [
            'username' => $username,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'birth_date' => $data['birth_date'],
                'email' => $email,
                'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]);
            $_SESSION['user_id'] = $userId;
            header('Location: /yap/public/');
            exit;
        case 'logout':
            //logout
            session_unset();
            session_destroy();
            header('Location: /yap/public/');
            exit;
        
        
    }
}

require_once __DIR__ . '/../../views/auth.php';