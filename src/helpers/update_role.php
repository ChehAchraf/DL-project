<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Helpers\Database;
use Classes\Admin;
$db = new Database();
$pdo = $db->getConnection();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$userId = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
$newRole = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

if (!$userId || !$newRole) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

try {
    $admin = new Admin("","","","","");
    $result = $admin->updateUserRole($pdo, $userId, $newRole);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Failed to update role']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}