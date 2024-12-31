<?php
namespace Classes;

use PDO;
use PDOException;
use Exception;

class Car {
    private $model;
    private $price;
    private $availability;
    private $categoryId;
    private $mileage;
    private $year;
    private $fuelType;
    private $transmission;
    private $description;
    private $imgPath;

    public function __construct($model, $price, $availability, $categoryId, $mileage, $year, $fuelType, $transmission, $description, $imgPath = null) {
        $this->model = $model;
        $this->price = $price;
        $this->availability = $availability;
        $this->categoryId = $categoryId;
        $this->mileage = $mileage;
        $this->year = $year;
        $this->fuelType = $fuelType;
        $this->transmission = $transmission;
        $this->description = $description;
        $this->imgPath = $imgPath;
    }

    public function addCar($pdo) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO cars (model, price, availability, category_id, mileage, year, fuel_type, transmission, description, img_path) 
                VALUES (:model, :price, :availability, :category_id, :mileage, :year, :fuel_type, :transmission, :description, :img_path)
            ");
            $stmt->execute([
                'model' => $this->model,
                'price' => $this->price,
                'availability' => $this->availability,
                'category_id' => $this->categoryId,
                'mileage' => $this->mileage,
                'year' => $this->year,
                'fuel_type' => $this->fuelType,
                'transmission' => $this->transmission,
                'description' => $this->description,
                'img_path' => $this->imgPath,
            ]);
            return "Car added successfully.";
        } catch (PDOException $e) {
            throw new Exception("Failed to add car: " . $e->getMessage());
        }
    }
    public static function uploadImage($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Image upload error: " . $file['error']);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Invalid image type. Allowed types are JPEG, PNG, and GIF.");
        }

        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . "_" . basename($file['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return 'uploads/' . $fileName;
        } else {
            throw new Exception("Failed to move uploaded image.");
        }
    }

    public static function getAllCars($pdo) {
        try {
            $stmt = $pdo->prepare(
                "SELECT cars.*, categories.name AS category_name 
                 FROM cars 
                 LEFT JOIN categories ON cars.category_id = categories.id"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch cars: " . $e->getMessage());
        }
    }

    public static function searchCars($pdo, $keyword) {
        try {
            $stmt = $pdo->prepare(
                "SELECT cars.*, categories.name AS category_name 
                 FROM cars 
                 LEFT JOIN categories ON cars.category_id = categories.id 
                 WHERE cars.model LIKE :keyword OR categories.name LIKE :keyword"
            );
            $stmt->execute(['keyword' => "%$keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to search cars: " . $e->getMessage());
        }
    }

    public static function getCarDetails($pdo, $car_id) {
        try {
            $stmt = $pdo->prepare(
                "SELECT cars.*, categories.name AS category_name 
                 FROM cars 
                 LEFT JOIN categories ON cars.category_id = categories.id 
                 WHERE cars.id = :id"
            );
            $stmt->execute(['id' => $car_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch car details: " . $e->getMessage());
        }
    }
}
