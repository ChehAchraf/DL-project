<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\User ;
use Helpers\Database;
use Classes\Car;

try {
    $db = new Database();
    $pdo = $db->getConnection();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $carId = $_POST['carId'] ?? null;
    if (!$carId) {
        throw new Exception('Car ID is required');
    }

    $db = new Database();
    $pdo = $db->getConnection();
    
    $result = Car::deleteCar($pdo, $carId);
    
    echo json_encode(['success' => true, 'message' => 'Car deleted successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>