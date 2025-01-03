<?php
// Classes/Reservation.php
namespace Classes;

class Reservation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function validateUser($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("Invalid user ID");
        }
    }

    public function validateCar($carId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM cars WHERE id = :car_id");
        $stmt->execute(['car_id' => $carId]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("Invalid car ID: {$carId}");
        }
    }

    public function checkAvailability($carId, $startDate, $endDate) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM reservations 
            WHERE car_id = :car_id 
            AND ((start_date BETWEEN :start_date AND :end_date) 
            OR (end_date BETWEEN :start_date AND :end_date))
        ");
        $stmt->execute([
            'car_id' => $carId,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
        if ($stmt->fetchColumn() > 0) {
            throw new \Exception("Car is not available for selected dates");
        }
    }

    public function create($userId, $carId, $startDate, $endDate, $pickupLocation, $returnLocation) {
        // Validate user first
        $this->validateUser($userId);
        
        // Then validate car and availability
        $this->validateCar($carId);
        $this->checkAvailability($carId, $startDate, $endDate);

        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO `reservations` 
                (`user_id`, `car_id`, `start_date`, `end_date`, `pickup_location`, `return_location`)
                VALUES (:user_id, :car_id, :start_date, :end_date, :pickup_location, :return_location)"
            );
            
            $stmt->execute([
                'user_id' => $userId,
                'car_id' => $carId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'pickup_location' => $pickupLocation,
                'return_location' => $returnLocation
            ]);

            return "Reservation created successfully";
        } catch (\PDOException $e) {
            throw new \Exception("Failed to create reservation: " . $e->getMessage());
        }
    }
}
