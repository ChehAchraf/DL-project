<?php
// helpers/review_handler.php

require __DIR__ . '/../../vendor/autoload.php';
header('Content-Type: application/json');
session_start();

use Helpers\Database;
use Classes\Client;
use Classes\Session;
use Classes\Review;

Session::validateSession();

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $user_id = $_SESSION['id'];
    $client = new Client("", "", "", "", $user_id);

    $action = $_POST['action'] ?? 'add';

    switch ($action) {
        case 'add':
            $response = $client->AddReview(
                $pdo,
                $_POST['car_id'],
                $_POST['rating'],
                $_POST['comment']
            );
            echo json_encode(['success' => true, 'message' => $response]);
            break;

        case 'edit':
            $response = $client->EditReview(
                $pdo,
                $_POST['review_id'],
                $_POST['comment']
            );
            echo json_encode(['success' => true, 'message' => $response]);
            break;

        case 'delete':
            $review_id = $_POST['review_id'] ?? null;
            if (!$review_id) {
                throw new Exception('Review ID is required');
            }
            
            $result = $client->DeleteReview($pdo, $review_id);
            echo json_encode(['success' => true, 'message' => $result]);
            break;
        case 'restore':
            $review_id = $_POST['review_id'] ?? null;
            if (!$review_id) {
                throw new Exception('Review ID is required');
            }
            
            $result = Review::restoreReview($pdo, $review_id);
            echo json_encode(['success' => true, 'message' => 'Review restored successfully']);
            break;
        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
