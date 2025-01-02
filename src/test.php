<?php 
require __DIR__ . '/../vendor/autoload.php'; 

use Classes\Car;
use Classes\User;
use Classes\Admin;
use Helpers\Database;
use Classes\Client;

// $db = new Database();
// $pdo = $db->getConnection();

// $user1 = new User('ashraf' , "chehboun","12dd3","ashraddf@gmail.com");
// echo $user1->register($pdo);

// $admin = new Admin("admin","l3ladddwi","1ddddddd23","admin@admin.com");
// echo $admin->register($pdo);

// $car = new Car("Tesla Model S", 79999.99, "available", 1, 10000, 2022, "electric", "automatic", "A premium electric vehicle.");
// echo $car->addCar($pdo);

$db = new Database();
$pdo = $db->getConnection();
$client = new Client("","","","",1);
$client->ReserveCar($pdo,9,"04/02/2025","04/03/2025","ELhajeb","Fes");


