<?php

class Post{
    public static function create(PDO $pdo, array $postData): int {
    $sql = 'INSERT INTO posts(content, image_path, user_id) VALUES(:content, :image_path ,:user_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($postData);

    return (int) $pdo->lastInsertId();
    }
    public static function delete(PDO $pdo, int $postId, int $postUserId): bool {
    $sql = 'DELETE FROM posts WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $postId, 'user_id' => $postUserId]);

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

    public static function findById(PDO $pdo, int $postId, int $userId): array| false {
        $sql = 'SELECT
        p.id,
        p.content,
        p.image_path,
        p.created_at,
        u.username,
        u.profile_picture,
        
        COUNT(DISTINCT l.post_id) AS like_count,
        COUNT(DISTINCT c.id) AS comment_count,
        
        EXISTS (
        SELECT 1
        FROM posts_likes ul
        WHERE ul.post_id = p.id
        AND ul.user_id = :user_id
        ) AS liked
        
        FROM posts p
        
        JOIN users u
        ON p.user_id = u.id
        
        LEFT JOIN posts_likes l
        ON l.post_id = p.id

        LEFT JOIN comments c
        ON c.post_id = p.id

        WHERE p.id = :post_id
        
        GROUP BY 
        p.id,
        p.content,
        p.image_path,
        p.created_at,
        u.username';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findUserPosts(PDO $pdo, int $userId): array {
    $sql = 'SELECT
        p.id,
        p.content,
        p.image_path,
        p.created_at,
        u.username,
        u.profile_picture,
        
        COUNT(DISTINCT l.post_id) AS like_count,
        COUNT(DISTINCT c.id) AS comment_count,
        
        EXISTS (
        SELECT 1
        FROM posts_likes ul
        WHERE ul.post_id = p.id
        AND ul.user_id = :user_id
        ) AS liked
        
        FROM posts p
        
        JOIN users u
        ON p.user_id = u.id
        
        LEFT JOIN posts_likes l
        ON l.post_id = p.id

        LEFT JOIN comments c
        ON c.post_id = p.id

        WHERE p.user_id = :user_id
        
        GROUP BY 
        p.id,
        p.content,
        p.image_path,
        p.created_at,
        u.username
        
        ORDER BY p.created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAll(PDO $pdo, int $userId): array {
    $sql = 'SELECT
    p.id,
    p.content,
    p.image_path,
    p.created_at,
    u.username,
    u.profile_picture,
    
    COUNT(DISTINCT l.post_id) AS like_count,
    COUNT(DISTINCT c.id) AS comment_count,
    
    EXISTS (
    SELECT 1
    FROM posts_likes ul
    WHERE ul.post_id = p.id
    AND ul.user_id = :user_id
    ) AS liked
    
    FROM posts p
    
    JOIN users u
    ON p.user_id = u.id
    
    LEFT JOIN posts_likes l
    ON l.post_id = p.id

    LEFT JOIN comments c
    ON c.post_id = p.id
    
    GROUP BY 
    p.id,
    p.content,
    p.image_path,
    p.created_at,
    u.username
    
    ORDER BY p.created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function likePost(PDO $pdo, int $postId, int $userId): void {
    $sql = 'INSERT INTO posts_likes(user_id, post_id) VALUES(:user_id,:post_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['post_id' => $postId, 'user_id' => $userId]);
    }
    public static function unlikePost(PDO $pdo, int $postId, int $userId): void {
    $sql = 'DELETE FROM posts_likes
    WHERE user_id = :user_id
    AND post_id = :post_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([ 'post_id' => $postId,'user_id' => $userId]);
    }
    public static function getPostImage(PDO $pdo, int $postId, int $userId): array | false {
    $sql = 'SELECT image_path FROM posts WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt -> execute(['id'=> $postId, 'user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // public static function findAllProgressiveLoading(PDO $pdo, int $offset): array {
    // $sql = 'SELECT 
    //     p.id AS id, 
    //     p.content AS content, 
    //     p.image_path AS image_path,
    //     p.created_at AS created_at,
    //     u.username AS username
    //     FROM posts AS p 
    //     JOIN users AS u 
    //     ON p.user_id = u.id
    //     ORDER BY p.created_at DESC
    //     LIMIT 20 OFFSET :offset';
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['offset' => $offset]);
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }



}
