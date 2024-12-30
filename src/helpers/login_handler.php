<?php 
require __DIR__ . '/../../vendor/autoload.php'; 

use Classes\User ;
use Helpers\Database;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['email']) && isset($_POST['password'])){
        // sanitize the inputs
        $email = trim(htmlspecialchars(htmlentities($_POST['email'])));
        $password = trim(htmlspecialchars(htmlentities($_POST['password'])));
        // start the inserting proccess
        $db = new Database();
        $pdo = $db->getConnection();
        $user = new User("","",$email,$password);
        echo $user->login($pdo);
        echo $_SESSION['login_done'];
        header("Location: ../index.php");
}
}