<?php

namespace Classes;

class Comment {
    private $id;
    protected $content;
    protected $user_id;
    protected $article_id;
    private $created_at;

    public function __construct($content , $user_id, $article_id) {
        $this->content = $content;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function getCommentsByArticle($pdo, $article_id) {
        try {
            $stmt = $pdo->prepare("
                SELECT c.*, u.name as user_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.article_id = :article_id 
                ORDER BY c.created_at DESC
            ");
            $stmt->execute(['article_id' => $article_id]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function addComment($pdo) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO comments (article_id, user_id, comment, created_at) 
                VALUES (:article_id, :user_id, :content, NOW())
            ");
            return $stmt->execute([
                'article_id' => $this->article_id,
                'user_id' => $this->user_id,
                'content' => $this->content
            ]);
        } catch (\PDOException $e) {
            error_log("Error adding comment: " . $e->getMessage());
            return false;
        }
    }

    public function removeComment($pdo, $comment_id, $user_id) {
        try {
            $stmt = $pdo->prepare("
                DELETE FROM comments 
                WHERE id = :comment_id AND user_id = :user_id
            ");
            return $stmt->execute([
                'comment_id' => $comment_id,
                'user_id' => $user_id
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}
