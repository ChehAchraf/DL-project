<?php 
require __DIR__ . '/../../vendor/autoload.php'; 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Classes\User;

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$res = User::logout();

if($res) {
    // Clear any output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    header('Location: ../index.php');
    exit();
} else {
    echo "Logout failed";
}