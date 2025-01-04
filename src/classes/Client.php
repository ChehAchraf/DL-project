<?php 
// Classes/Client.php
namespace Classes;
use Classes\User;
use Classes\Session;
Session::validateSession();

class Client extends User {
    protected $userid;

    public function __construct($name, $secname, $email, $password, $userid) {
        parent::__construct($name, $secname, $email, $password);
        $this->userid = Session::validateSession(); 
    }

    public function ReserveCar($pdo, $carid, $st_date, $end_date, $pickup_location, $return_location) {
        // Validate car exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cars WHERE id = :car_id");
        $stmt->execute(['car_id' => $carid]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("Car not found");
        }
        $stmt = $pdo->prepare("SELECT availability FROM cars");
        $stmt->execute();
        if($stmt->fetchcolumn()== 'unavailable'){
            throw new \Exception("You cant Reserve an unavailable car");
        }

        // Validate user exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $this->userid]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("User not found");
        }
    
        $stmt = $pdo->prepare(
            "INSERT INTO `reservations` 
            (`user_id`, `car_id`, `start_date`, `end_date`, `pickup_location`, `return_location`)
            VALUES (:user_id, :car_id, :st_date, :end_date, :pickup_location, :return_location)"
        );
        
        $stmt->execute([
            'user_id' => $this->userid,
            'car_id' => $carid,
            'st_date' => $st_date,
            'end_date' => $end_date,
            'pickup_location' => $pickup_location,
            'return_location' => $return_location
        ]);
        
        return "Reservation completed successfully";
    }
    public function AddReview($pdo, $carid, $rating, $comment) {
        // Validate car exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cars WHERE id = :car_id");
        $stmt->execute(['car_id' => $carid]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("Car not found");
        }
    
        // Validate rating is between 1-5
        if ($rating < 1 || $rating > 5) {
            throw new \Exception("Rating must be between 1 and 5");
        }
    
        // Check if user has already reviewed this car
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = :user_id AND car_id = :car_id AND is_deleted = FALSE");
        $stmt->execute([
            'user_id' => $this->userid,
            'car_id' => $carid
        ]);
        if ($stmt->fetchColumn() > 0) {
            throw new \Exception("You have already reviewed this car");
        }
    
        $stmt = $pdo->prepare(
            "INSERT INTO reviews (user_id, car_id, rating, comment) 
             VALUES (:user_id, :car_id, :rating, :comment)"
        );
        
        $stmt->execute([
            'user_id' => $this->userid,
            'car_id' => $carid,
            'rating' => $rating,
            'comment' => $comment
        ]);
    
        return "Review added successfully";
    }

    public function EditReview($pdo, $reviewId, $comment) {
        $stmt = $pdo->prepare("
            UPDATE reviews 
            SET comment = :comment 
            WHERE id = :review_id AND user_id = :user_id AND is_deleted = FALSE
        ");
        
        $result = $stmt->execute([
            'comment' => $comment,
            'review_id' => $reviewId,
            'user_id' => $this->userid
        ]);

        if (!$result) {
            throw new \Exception("Failed to update review");
        }

        return "Review updated successfully";
    }

    public function DeleteReview($pdo, $reviewId) {
        $stmt = $pdo->prepare("
            UPDATE reviews 
            SET is_deleted = TRUE 
            WHERE id = :review_id AND user_id = :user_id
        ");
        
        $result = $stmt->execute([
            'review_id' => $reviewId,
            'user_id' => $this->userid
        ]);

        if (!$result) {
            throw new \Exception("Failed to delete review");
        }

        return "Review deleted successfully";
    }
    
    public function getuserinformation($pdo,$uderid) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $uderid]); 
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getreservationinformation($pdo,$userid) {
        $stmt = $pdo->prepare("SELECT 
                    reservations.start_date, 
                    reservations.end_date, 
                    reservations.id,
                    reservations.pickup_location, 
                    reservations.return_location,  
                    reservations.status, 
                    cars.model AS car_model, 
                    users.name AS user_name
                FROM 
                    reservations
                INNER JOIN 
                    cars ON reservations.car_id = cars.id
                INNER JOIN 
                    users ON reservations.user_id = users.id
                WHERE 
                    users.id = :user_id;"); 
        $stmt->execute(['user_id' => $userid]); 
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getuserreviews($pdo,$userid) {
        $stmt = $pdo->prepare("SELECT 
                    reviews.id,
                    reviews.comment, 
                    reviews.rating,
                    reviews.created_at, 
                    cars.model AS car_model, 
                    users.name AS user_name
                FROM 
                    reviews
                INNER JOIN 
                    cars ON reviews.car_id = cars.id
                INNER JOIN 
                    users ON reviews.user_id = users.id
                WHERE 
                    users.id = :user_id;"); 
        $stmt->execute(['user_id' => $userid]); 
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
