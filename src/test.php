<?php 
require __DIR__ . '/../vendor/autoload.php'; 

use Classes\Car;
use Classes\User;
use Helpers\Database;

$db = new Database();
$pdo = $db->getConnection();

$user1 = new User('ashraf' , "chehboun","12dd3","ashraddf@gmail.com");
echo $user1->register($pdo);