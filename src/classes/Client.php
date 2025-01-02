<?php 
namespace Classes;
use Classes\User;
session_start();
class Client extends User {
    protected $userid;

    public function __construct($name, $secname, $email, $password, $userid = null) {
        parent::__construct($name, $secname, $email, $password);
        $this->userid = $userid ?: $_SESSION['id']; 
    }

    public function ReserveCar($pdo, $carid, $st_date, $end_date, $pickup_location, $return_location) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cars WHERE id = :car_id");
        $stmt->execute(['car_id' => $carid]);
        if ($stmt->fetchColumn() == 0) {
            throw new \Exception("Invalid car IDff echo{$carid}. ");
        }
    
        $stmt = $pdo->prepare(
            "INSERT INTO `reservations` 
            (`user_id`, `car_id`, `start_date`, `end_date`, `pickup_location`, `return_location`)
            VALUES (:user_id, :car_id, :st_date, :end_date, :pickup_location, :return_location)"
        );
        $stmt->execute([
            'user_id' => $this->userid,  
            'car_id' => $carid,
            'st_date' => $st_date,
            'end_date' => $end_date,
            'pickup_location' => $pickup_location,
            'return_location' => $return_location
        ]);
        return "done";
    }
    // public function AddReview($pdo,$userid,$carid,$comment,$is_deleted=false){
    //     $stmt = $pdo->prepare("SELECT INNTO ")
    // }
}
?>
