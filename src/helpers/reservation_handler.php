<?php 
// helpers/reservation_handler.php
require __DIR__ . '/../../vendor/autoload.php'; 

use Helpers\Database;
use Classes\Client;
use Classes\Session;

try {
    Session::validateSession(); 
    
    $db = new Database();
    $pdo = $db->getConnection();

    $client = new Client("", "", "", "");
    
    $response = $client->ReserveCar(
        $pdo,
        $_POST['car_id'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['pickup_location'],
        $_POST['return_location']
    );

    echo json_encode(['success' => true, 'message' => $response]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
