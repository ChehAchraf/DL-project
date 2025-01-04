<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\User ;
use Helpers\Database;
use Classes\Car;

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $carId = filter_var($_POST['carId'], FILTER_VALIDATE_INT);
    if (!$carId) {
        throw new Exception('Car ID is required');
    }

    $db = new Database();
    $pdo = $db->getConnection();
    
    $updateData = [
        'model' => $_POST['model'],
        'price' => filter_var($_POST['price'], FILTER_VALIDATE_FLOAT),
        'availability' => $_POST['availability'],
        'category' => $_POST['category'],
        'mileage' => filter_var($_POST['mileage'], FILTER_VALIDATE_INT),
        'year' => filter_var($_POST['year'], FILTER_VALIDATE_INT),
        'fuel_type' => $_POST['fuel_type'],
        'transmission' => $_POST['transmission'],
        'description' => $_POST['description']
    ];

    $result = Car::updateCar($pdo, $carId, $updateData);
    
    echo json_encode(['success' => true, 'message' => 'Car updated successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}