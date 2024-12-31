<?php 
require __DIR__ . '/../vendor/autoload.php'; 

use Classes\Car;
use Classes\User;
use Classes\Admin;
use Helpers\Database;

// $db = new Database();
// $pdo = $db->getConnection();

// $user1 = new User('ashraf' , "chehboun","12dd3","ashraddf@gmail.com");
// echo $user1->register($pdo);

// $admin = new Admin("admin","l3ladddwi","1ddddddd23","admin@admin.com");
// echo $admin->register($pdo);

// $car = new Car("Tesla Model S", 79999.99, "available", 1, 10000, 2022, "electric", "automatic", "A premium electric vehicle.");
// echo $car->addCar($pdo);

try {
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM `categories`");
    $stmt->execute();

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        echo "ID: " . $category['id'] . "<br>";
        echo "Name: " . $category['name'] . "<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
                 

