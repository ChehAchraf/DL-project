<?php
namespace Classes;

class Review {
    private $id;
    private $userId;
    private $carId;
    private $rating;
    private $comment;
    private $createdAt;
    private $isDeleted;

    public function __construct($userId, $carId, $comment, $rating) {
        $this->userId = $userId;
        $this->carId = $carId;
        $this->comment = $comment;
        $this->rating = $rating;
        $this->isDeleted = false;
    }

    public static function create($pdo, $userId, $carId, $comment, $rating) {
        $stmt = $pdo->prepare("
            INSERT INTO reviews (user_id, car_id, comment, rating) 
            VALUES (:user_id, :car_id, :comment, :rating)
        ");
        
        return $stmt->execute([
            'user_id' => $userId,
            'car_id' => $carId,
            'comment' => $comment,
            'rating' => min(max($rating, 1), 5) // Ensure rating is between 1 and 5
        ]);
    }

    public static function getByCarId($pdo, $carId) {
        $stmt = $pdo->prepare("
            SELECT r.*, u.name, u.s_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.car_id = :car_id 
            AND r.is_deleted = FALSE 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['car_id' => $carId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getByUserId($pdo, $userId) {
        $stmt = $pdo->prepare("
            SELECT r.*, c.model 
            FROM reviews r 
            JOIN cars c ON r.car_id = c.id 
            WHERE r.user_id = :user_id 
            AND r.is_deleted = FALSE 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function delete($pdo, $reviewId, $userId) {
        $stmt = $pdo->prepare("
            UPDATE reviews 
            SET is_deleted = TRUE 
            WHERE id = :review_id 
            AND user_id = :user_id
        ");
        return $stmt->execute([
            'review_id' => $reviewId,
            'user_id' => $userId
        ]);
    }

    public static function hasUserReviewedCar($pdo, $userId, $carId) {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as count 
            FROM reviews 
            WHERE user_id = :user_id 
            AND car_id = :car_id 
            AND is_deleted = FALSE
        ");
        $stmt->execute([
            'user_id' => $userId,
            'car_id' => $carId
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public static function getAverageRating($pdo, $carId) {
        $stmt = $pdo->prepare("
            SELECT 
                ROUND(AVG(rating), 1) as average_rating, 
                COUNT(*) as total_reviews 
            FROM reviews 
            WHERE car_id = :car_id 
            AND is_deleted = FALSE
        ");
        $stmt->execute(['car_id' => $carId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function restoreReview($pdo, $reviewId) {
        $stmt = $pdo->prepare("
            UPDATE reviews 
            SET is_deleted = FALSE 
            WHERE id = :review_id
        ");
        
        $stmt->execute(['review_id' => $reviewId]);
        
        if ($stmt->rowCount() === 0) {
            throw new \Exception("Review not found or already restored");
        }
        
        return true;
    }

    public static function listReviews($pdo) {
        $stmt = $pdo->prepare("
            SELECT 
                r.id,
                r.user_id,
                r.car_id,
                r.comment,
                r.rating,
                r.created_at,
                r.is_deleted,
                u.name,
                u.s_name,
                c.model
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            JOIN cars c ON r.car_id = c.id
            ORDER BY r.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
