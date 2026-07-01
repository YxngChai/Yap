<?php
require __DIR__ . '/../config/db.php';


class Post{
    public static function create(PDO $pdo, array $postData): void {
    $sql = 'INSERT INTO posts(content, user_id) VALUES(:content,:user_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($postData);
    }

}
