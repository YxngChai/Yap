<?php

class User{
    public static function create(PDO $pdo, array $userData): int {
    $sql = 'INSERT INTO users(username, name, surname, birth_date, email, password_hash) VALUES(:username, :name, :surname, :birth_date, :email, :password_hash)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($userData);
    return $pdo->lastInsertId();
    }
    public static function updateDetails(PDO $pdo, array $data): bool {
    $sql = 'UPDATE users SET name = :name, surname = :surname, birth_date = :birth_date WHERE id = :user_id';
    $stmt = $pdo -> prepare($sql);
    return $stmt->execute($data);
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
    public static function getProfilePicture(PDO $pdo, int $userId) {
    $sql = 'SELECT profile_picture FROM users WHERE id = :userId';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getHash(PDO $pdo, string $email , int $userId) {
    $sql = 'SELECT password_hash FROM users WHERE email = :email AND id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email,'user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function updateHash(PDO $pdo, string $password , int $userId):bool {
    $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :user_id';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['password_hash' => $password,'user_id' => $userId]);
    }
    

    public static function addProfilePicture(PDO $pdo, string $filepath, int $userId ): bool{
    $sql = 'UPDATE users SET profile_picture = :profile_picture WHERE id  = :userId';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['profile_picture' => $filepath, 'userId' => $userId]);
    }

    public static function getProfilePicturePath(?string $profilePicture): string {
    if (!$profilePicture) {
        return '/yap/public/assets/images/profile_anonymous.jpeg';
    } else {
        return '/yap/public/assets/uploads/' . $profilePicture;
        }
    }
    public static function getCoverImage(PDO $pdo, int $userId) {
    $sql = 'SELECT cover_picture FROM users WHERE id = :userId';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function addCoverimage(PDO $pdo, string $filepath, int $userId ): bool{
    $sql = 'UPDATE users SET cover_picture = :cover_picture WHERE id  = :userId';
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['cover_picture' => $filepath, 'userId' => $userId]);
    }
    public static function getCoverImagePath(?string $coverImage): string {
    if (!$coverImage) {
        return '/yap/public/assets/images/cover_default.jpg';
    } else {
        return '/yap/public/assets/uploads/' . $coverImage;
        }
    }
}
