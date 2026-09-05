<?php

class Comment{
    public static function create(PDO $pdo, array $commentData): int {
    $sql = 'INSERT INTO comments(content, image_path, user_id, post_id) VALUES(:content, :image_path, :user_id, :post_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($commentData);

    return (int) $pdo->lastInsertId();
    }
    public static function delete(PDO $pdo, int $commentId, int $commentUserId ): bool {
    $sql = 'DELETE FROM comments WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $commentId, 'user_id' => $commentUserId]);

    return $stmt->rowCount() > 0;
    }

    public static function update(PDO $pdo, array $commentData): void {
    $sql = 'UPDATE comments SET content = :content, `image_path` = :image_path WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($commentData);
    }

    public static function removeImage(PDO $pdo,  int $commentId, int $commentUserId): void {
    $sql = 'UPDATE comments SET  image_path = NULL WHERE id = :id AND user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $commentId, 'user_id' => $commentUserId]);
    }

    public static function findById(PDO $pdo, int $commentId, int $userId): array| false {
        $sql = 'SELECT
        c.id,
        c.post_id,
        c.user_id,
        c.content,
        c.image_path,
        c.created_at,
        u.username,
        u.profile_picture,
        
        COUNT(l.comment_id) AS like_count,
        
        EXISTS (
        SELECT 1
        FROM comments_likes ul
        WHERE ul.comment_id = c.id
        AND ul.user_id = :user_id
        ) AS liked
        
        FROM comments c
        
        JOIN users u
        ON c.user_id = u.id
        
        LEFT JOIN comments_likes l
        ON l.comment_id = c.id

        WHERE c.id = :comment_id
        
        GROUP BY 
        c.id,
        c.post_id,
        c.user_id,
        c.content,
        c.image_path,
        c.created_at,
        u.username';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function findUserComments(PDO $pdo, int $userId): array {
    $sql = 'SELECT
        c.id,
        c.post_id,
        c.user_id,
        c.content,
        c.image_path,
        c.created_at,
        u.username,
        u.profile_picture,
        
        COUNT(l.comment_id) AS like_count,
        
        EXISTS (
        SELECT 1
        FROM comments_likes ul
        WHERE ul.comment_id = c.id
        AND ul.user_id = :user_id
        ) AS liked
        
        FROM comments c
        
        JOIN users u
        ON c.user_id = u.id
        
        LEFT JOIN comments_likes l
        ON l.comment_id = c.id

        WHERE c.user_id = :user_id
        
        GROUP BY 
        c.id,
        c.post_id,
        c.user_id,
        c.content,
        c.image_path,
        c.created_at,
        u.username
        
        ORDER BY c.created_at ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findPostComments(PDO $pdo, int $postId, int $userId): array {
    $sql = 'SELECT
    c.id,
    c.post_id,
    c.user_id,
    c.content,
    c.image_path,
    c.created_at,
    u.username,
    u.profile_picture,
    
    COUNT(l.comment_id) AS like_count,
    
    EXISTS (
    SELECT 1
    FROM comments_likes ul
    WHERE ul.comment_id = c.id
    AND ul.user_id = :user_id
    ) AS liked
    
    FROM comments c
    
    JOIN users u
    ON c.user_id = u.id
    
    LEFT JOIN comments_likes l
    ON l.comment_id = c.id

    WHERE c.post_id = :post_id
    
    GROUP BY 
    c.id,
    c.post_id,
    c.user_id,
    c.content,
    c.image_path,
    c.created_at,
    u.username
    
    ORDER BY c.created_at ASC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['post_id' => $postId,'user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function likeComment(PDO $pdo, int $commentId, int $userId): void {
    $sql = 'INSERT INTO comments_likes(user_id, comment_id) VALUES(:user_id,:comment_id)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['comment_id' => $commentId, 'user_id' => $userId]);
    }
    public static function unlikeComment(PDO $pdo, int $commentId, int $userId): void {
    $sql = 'DELETE FROM comments_likes
    WHERE user_id = :user_id
    AND comment_id = :comment_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([ 'comment_id' => $commentId,'user_id' => $userId]);
    }

}
