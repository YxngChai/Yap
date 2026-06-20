<?php
require __DIR__ . '/../config/db.php';

$sqlQuery = 'INSERT INTO users(username, name, surname, birth_date, email, password_hash) VALUES(:username, :name, :surname, :birth_date, :email, :password_hash)';

$insertUser = $pdo->prepare($sqlQuery);

$insertUser->execute([
    'username' => 'BBY0da',
    'name' => 'Baby',
    'surname' => 'Yoda',
    'birth_date' => '1956-12-24',
    'email' => 'babyyoda@gmail.com',
    'password_hash' => password_hash('mando', PASSWORD_DEFAULT),

]);

echo "User inserted";

