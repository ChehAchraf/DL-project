<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\User ;
use Helpers\Database;
use Classes\Admin;
use Classes\Car;

try {
    $db = new Database();
    $pdo = $db->getConnection();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }
    $name = $_POST['name'] ?? null;
    if (!$name) { 
        throw new Exception('Category name is required');
    }
    $admin = new Admin("","","","","");
    $result = $admin->createcategory($pdo, $name);
    echo json_encode(['success' => $result]);
    exit;
}catch(Exception $e){
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}