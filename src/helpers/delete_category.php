<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\Admin;
use Helpers\Database;

try {
    $db = new Database();
    $pdo = $db->getConnection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $categoryId = $_POST['category_id'] ?? null;
    if (!$categoryId) {
        throw new Exception('Category ID is required');
    }

    $admin = new Admin("", "", "", "", "");
    $result = $admin->deleteCategory($pdo, $categoryId); // Pass category_id to the method
    echo json_encode(['success' => true, 'message' => $result]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}