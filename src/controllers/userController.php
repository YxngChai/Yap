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
        exit;
    case 'delete_user':
        exit;
}