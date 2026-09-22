<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../validators/validator.php';
require_once __DIR__ . '/../helpers/errors.php';

$pdo = Database::getConnection();

$data = $_POST;

verifyCsrf();

switch($data['action']){
    case 'update_user':

        $rules = [
            'name' => ['required' => true, 'min' => 2, 'max' => 50, 'name' => true],
            'surname' => ['required' => true, 'min' => 2, 'max' => 100, 'name' => true],
            'birth_date' => ['required' => true, 'date' => true],
        ];
        $errors = Validator::validateUser($data, $rules);
        if(!empty($errors)){
            jsonError($errors);
            exit;
        }

        if(User::updateDetails($pdo, [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'birth_date' => $data['birth_date'],
            'user_id' => $_SESSION['user']['id']
        ])) {
            $_SESSION['user']['name'] = $data['name'];
            $_SESSION['user']['surname'] = $data['surname'];
            $_SESSION['user']['birth_date'] = $data['birth_date'];
            header('Content-Type: application/json');

            echo json_encode([
                'success' => true,
                'errors' => null
            ]);
            exit;
        } else {
            jsonError('Error, try again later.');
            exit;
        }


    case 'update_password':
        if (
            !isset($data['old_password'], $data['new_password'], $data['new_password_verification'])
            || !is_string($data['old_password'])
            || !is_string($data['new_password'])
            || !is_string($data['new_password_verification'])
        ) {
            jsonError(['Invalid request']);
            exit;
        }
        $hash = User::getHash($pdo, $_SESSION['user']['email'], $_SESSION['user']['id']);

        if(!$hash || !password_verify($data['old_password'], $hash['password_hash'])){
            jsonError(['Incorrect password']);
            exit;
        }

        if($data['new_password'] !== $data['new_password_verification']) {
            jsonError(['Passwords do not match']);
            exit;
        }
        if(strlen($data['new_password']) < 8 ){
            jsonError(['Password must be at least 8 characters']);
            exit;
        }
        if(strlen($data['new_password']) > 72 ){
            jsonError(['Password must be at most 72 characters']);
            exit;
        }

        if(!User::updateHash($pdo, password_hash($data['new_password'], PASSWORD_DEFAULT), $_SESSION['user']['id'] )){
            jsonError(['Error, please try again later']);
            exit;
        }
        header('Content-Type: application/json');

        echo json_encode([
            'success' => true,
            'errors' => null
        ]);

        exit;


    case 'delete_user':
        exit;
}