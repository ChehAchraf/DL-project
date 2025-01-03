<?php 
namespace Classes;
use Classes\User;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Client extends User {
    public function __construct($name, $secname, $email, $password) {
        parent::__construct($name, $secname, $email, $password);
    }

    public function hasReservation($pdo) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS reservation_count FROM reservations WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $_SESSION['id']]);
        $result = $stmt->fetch();
        return $result['reservation_count'] > 0;
    }

    public function hasReviewedCar($pdo, $carId) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS review_count FROM reviews WHERE user_id = :user_id AND car_id = :car_id AND is_deleted = FALSE");
        $stmt->execute(['user_id' => $_SESSION['id'], 'car_id' => $carId]);
        $result = $stmt->fetch();
        return $result['review_count'] > 0;
    }

    public function submitReview($pdo, $carId, $reviewText, $rating) {
        if (!$this->hasReservation($pdo)) {
            throw new \Exception("You must make a reservation before submitting a review.");
        }

        if ($this->hasReviewedCar($pdo, $carId)) {
            throw new \Exception("You have already reviewed this car.");
        }

        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, car_id, comment, rating) VALUES (:user_id, :car_id, :comment, :rating)");
        $stmt->execute([
            'user_id' => $_SESSION['id'],
            'car_id' => $carId,
            'comment' => $reviewText,
            'rating' => $rating
        ]);
        return "Review submitted successfully!";
    }

    public function deleteReview($pdo, $reviewId) {
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :review_id AND user_id = :user_id AND is_deleted = FALSE");
        $stmt->execute([
            'review_id' => $reviewId,
            'user_id' => $_SESSION['id']
        ]);

        $review = $stmt->fetch();
        if (!$review) {
            throw new \Exception("You can only delete your own reviews, or the review doesn't exist.");
        }

        $stmt = $pdo->prepare("UPDATE reviews SET is_deleted = TRUE WHERE id = :review_id");
        $stmt->execute(['review_id' => $reviewId]);

        return "Review deleted successfully!";
    }
}
