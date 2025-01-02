<?php 
require __DIR__ . '/../../vendor/autoload.php'; 
session_start();
use Helpers\Database;
use Classes\Client;


$userid = $_SESSION['id'];

$db = new Database();
$pdo = $db->getConnection();

$client = new Client("", "", "", "", $userid);

$carid = $_POST['car_id'];
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$pickupLocation = $_POST['pickup_location'];
$returnLocation = $_POST['return_location'];

try {
    $response = $client->ReserveCar($pdo, $carid, $startDate, $endDate, $pickupLocation, $returnLocation);
    echo json_encode(['success' => true, 'message' => $response]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
