<?php 
require __DIR__ . '/../../vendor/autoload.php'; 

use Classes\User ;
use Helpers\Database;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'] ) ){
        // get and sanitize the data
        $first_name = trim(htmlspecialchars(htmlentities($_POST['first_name'])));
        $last_name = trim(htmlspecialchars(htmlentities($_POST['last_name'])));
        $email = trim(htmlspecialchars(htmlentities($_POST['email'])));
        $password = trim(htmlspecialchars((htmlentities($_POST['password']))));
        // check if the email not correct
        if(!filter_var($email, FILTER_SANITIZE_EMAIL)){
            header("Location: ../index.php");
        }
        // start the inserting 
        $db = new Database();
        $pdo = $db->getConnection();
        $user = new User($first_name,$last_name,$email,$password);
        echo $user->register($pdo);
        header("location: ../index.php");
        exit();
    }

}