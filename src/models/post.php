<?php
require __DIR__ . '/../config/db.php';


class Post{
    public static function create(PDO $pdo, array $postData): void {
    $sql = 'INSERT INTO posts(content, image_path, user_id) VALUES(:content, :image_path ,:user_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($postData);
    }
    public static function delete(PDO $pdo, int $postId, int $postUserID): bool {
    $sql = 'DELETE FROM posts WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId, 'user_id' => $postUserID]);

    return $stmt->rowCount() > 0;
    }

}
