<?php
require __DIR__ . '/../../vendor/autoload.php'; 
use Classes\Car;
use Helpers\Database;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database() ;
        $pdo = $db->getConnection();
        $imgPath = Car::uploadImage($_FILES['car_image']);
        
        $car = new Car(
            $_POST['model'],
            $_POST['price'],
            $_POST['availability'],
            $_POST['category_id'],
            $_POST['mileage'],
            $_POST['year'],
            $_POST['fuel_type'],
            $_POST['transmission'],
            $_POST['description'],
            $imgPath
        );

        echo $car->addCar($pdo);
        $_SESSION['car_added'] = "text";
        header("Location: ../manage/index.php");
        exit();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
