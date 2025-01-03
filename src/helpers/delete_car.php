<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Helpers\Database;
use Classes\Car;

$db = new Database();
$pdo = $db->getConnection();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$carId = filter_input(INPUT_POST, 'carId', FILTER_VALIDATE_INT);

if (!$carId) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid car ID']);
    exit;
}

try {
    $result = Car::deleteCar($pdo, $carId);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Failed to delete car']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
