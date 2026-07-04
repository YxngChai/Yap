<?php

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
    public static function update(PDO $pdo, array $postData): void {
    $sql = 'UPDATE posts SET content = :content, `image_path` = :image_path WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($postData);
    }
    public static function removeImage(PDO $pdo,  int $postId, int $postUserId): void {
    $sql = 'UPDATE posts SET  image_path = NULL WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId, 'user_id' => $postUserId]);
    }
    public static function findById(PDO $pdo, int $id): array| false {
    $sql = 'SELECT * FROM posts WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findUserPosts(PDO $pdo, int $userId): array {
    $sql = 'SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function findAll(PDO $pdo): array {
    $sql = 'SELECT 
        p.id AS id, 
        p.content AS content, 
        p.image_path AS image_path,
        p.created_at AS created_at,
        u.username AS username
        FROM posts AS p 
        JOIN users AS u 
        ON p.user_id = u.id
        ORDER BY p.created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
