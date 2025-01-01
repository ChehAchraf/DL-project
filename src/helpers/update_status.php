<?php
require __DIR__ . '/../../vendor/autoload.php';

use Classes\Admin;
use Classes\Car;
use Helpers\Database;

$res_id = $_GET['id'];
$res_status = $_GET['status'];
$db = new Database();
$pdo = $db->getConnection();
$admin = new Admin("","","","");
$admin->EditStatus($pdo, $res_id, $res_status);

echo "Status updated successfully";
?>