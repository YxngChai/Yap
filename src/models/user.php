<?php


class User{
    public static function create(PDO $pdo, array $userData): void {

        $sql = 'INSERT INTO users(username, name, surname, birth_date, email, password_hash) VALUES(:username, :name, :surname, :birth_date, :email, :password_hash)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($userData);
    }

    public static function findByEmail(PDO $pdo, string $email) {

    $sql = 'SELECT * FROM  users WHERE email = :email';

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
