<?php

class User{
    public static function create(PDO $pdo, array $userData): int {
    $sql = 'INSERT INTO users(username, name, surname, birth_date, email, password_hash) VALUES(:username, :name, :surname, :birth_date, :email, :password_hash)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($userData);

    return $pdo->lastInsertId();
    }

    public static function findByEmail(PDO $pdo, string $email) {
    $sql = 'SELECT * FROM  users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findByUsername(PDO $pdo, string $username) {
    $sql = 'SELECT * FROM  users WHERE username = :username';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findById(PDO $pdo, int $userId) {
    $sql = 'SELECT * FROM  users WHERE id = :userId';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function addProfilePicture(PDO $pdo, string $filepath, int $userId ): void{
    $sql = 'UPDATE users SET profile_picture = :profile_picture WHERE id  = :userId';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['profile_picture' => $filepath, 'userId' => $userId]);
    }

}
