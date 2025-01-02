<?php 
namespace Classes;
use Classes\User;

class Client extends User{

    public function __construct($name, $secname, $email, $password) {
        parent::__construct($name, $secname, $email, $password);
    }

    public function ReserveCar($pdo){
        $stmt = $pdo->prepare("INSERT INTO `reservations` 
                                (`user_id`, `car_id`, `start_date`, `end_date`, `pickup_location`, `return_location`)
                                VALUES (:user_id , :car_id , :st_date , :end_date , :pickup_location, :return_location) ");
    }

}