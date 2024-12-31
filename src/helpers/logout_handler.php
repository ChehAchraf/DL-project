<?php 
require __DIR__ . '/../../vendor/autoload.php'; 

use Classes\User;


if($_SERVER['REQUEST_METHOD'] == "POST"){
        $res = User::logout();
        if($res)
        {
            header("Location: ../index.php");
        }
} else {
    echo 'bb';
}