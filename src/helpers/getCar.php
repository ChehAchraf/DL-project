<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\User ;
use Helpers\Database;
use Classes\Car;

try {
    if (!isset($_GET['id'])) {
        throw new Exception('Car ID is required');
    }

    $carId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($carId === false) {
        throw new Exception('Invalid car ID');
    }

    $db = new Database();
    $pdo = $db->getConnection();
    
    $car = Car::getCarDetails($pdo, $carId);
    
    if (!$car) {
        throw new Exception('Car not found');
    }
    
    echo json_encode(['success' => true, 'data' => $car]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
