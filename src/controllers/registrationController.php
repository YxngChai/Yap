<?php

require __DIR__ . '/../config/db.php';
require __DIR__ . '/../models/user.php';

User::create($pdo, [
 'username' => 'mand0',
    'name' => 'Din',
    'surname' => 'Djarin',
    'birth_date' => '1956-02-13',
    'email' => 'mando@gmail.com',
    'password_hash' => password_hash('babyyoda', PASSWORD_DEFAULT),

]);

echo "succes!";
