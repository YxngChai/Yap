<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/user.php';

$user = User::findByEmail($pdo, 'babyyoda@gmail.com');

if (!$user ){
    echo "NO user";
} else {
    echo "Welcome";
}