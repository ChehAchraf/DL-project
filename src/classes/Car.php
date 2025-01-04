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
    protected $lignes_par_page = 2;

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

    public function getLinesParPage(){
        return $this->lignes_par_page;
    }

    public function Nbr_cars($pdo){
        $query = $pdo->prepare("SELECT count(*) AS total FROM cars");
        $query->execute();
        $result = $query->fetch();
        return $result['total'];
    }
    
    public  function getAllCars($pdo, $page = 1) {
        $offset = ($page - 1) * $this->lignes_par_page;
        $query = $pdo->prepare("SELECT * FROM cars LIMIT :offset, :limit");
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->bindParam(':limit', var: $this->lignes_par_page, type: PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
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
    public static function filterCars($pdo, $search = '', $category = '') {
        try {
            $query = "SELECT c.*, cat.name AS category_name 
                      FROM cars c 
                      JOIN categories cat ON c.category_id = cat.id 
                      WHERE c.model LIKE :search";
    
            if ($category && $category !== 'All Categories') {
                $query .= " AND cat.name LIKE :category";
            }
    
            $stmt = $pdo->prepare($query);
            
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    
            if ($category && $category !== 'All Categories') {
                $stmt->bindValue(':category', '%' . $category . '%', PDO::PARAM_STR);
            }
    
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching filtered cars: " . $e->getMessage());
        }
    }
    
    // Add this to the Car class
    public static function deleteCar($pdo, $carId) {
        try {
            $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
            return $stmt->execute([$carId]);
        } catch (PDOException $e) {
            throw new Exception("Failed to delete car: " . $e->getMessage());
        }
    }

    // Add this to get all cars with category names
    public static function getAllCarsWithCategories($pdo) {
        try {
            $stmt = $pdo->query("
                SELECT c.*, cat.name as category_name 
                FROM cars c
                LEFT JOIN categories cat ON c.category_id = cat.id
                ORDER BY c.id DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch cars: " . $e->getMessage());
        }
    }

    public static function updateCar($pdo, $carId, $data) {
        try {
            $sql = "UPDATE cars SET 
                    model = :model,
                    price = :price,
                    availability = :availability,
                    category_id = :category_id,
                    mileage = :mileage,
                    year = :year,
                    fuel_type = :fuel_type,
                    transmission = :transmission,
                    description = :description
                    WHERE id = :id";
                    
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindValue(':id', $carId);
            $stmt->bindValue(':model', $data['model']);
            $stmt->bindValue(':price', $data['price']);
            $stmt->bindValue(':availability', $data['availability']);
            $stmt->bindValue(':category_id', $data['category_id']);
            $stmt->bindValue(':mileage', $data['mileage']);
            $stmt->bindValue(':year', $data['year']);
            $stmt->bindValue(':fuel_type', $data['fuel_type']);
            $stmt->bindValue(':transmission', $data['transmission']);
            $stmt->bindValue(':description', $data['description']);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to update car: " . $e->getMessage());
        }
    }
    
    public static function getCar($pdo, $carId) {
        try {
            $stmt = $pdo->prepare("
                SELECT c.*, cat.name as category_name 
                FROM cars c
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.id = :id
            ");
            $stmt->execute(['id' => $carId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch car: " . $e->getMessage());
        }
    }
    
    
}
