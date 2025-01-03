<?php
// helpers/review_handler.php

require __DIR__ . '/../../vendor/autoload.php';
session_start();

use Helpers\Database;
use Classes\Client;

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $client = new Client("", "", "", "");

    $action = $_POST['action'] ?? 'add';

    switch ($action) {
        case 'add':
            $response = $client->AddReview(
                $pdo,
                $_POST['car_id'],
                $_POST['rating'],
                $_POST['comment']
            );
            break;

        case 'edit':
            $response = $client->EditReview(
                $pdo,
                $_POST['review_id'],
                $_POST['comment']
            );
            break;

        case 'delete':
            $response = $client->DeleteReview(
                $pdo,
                $_POST['review_id']
            );
            break;

        default:
            throw new Exception('Invalid action');
    }

    echo json_encode(['success' => true, 'message' => $response]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
