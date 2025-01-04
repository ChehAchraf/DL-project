<?php
namespace Classes;

class Session {
    public static function validateSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['id']) || !isset($_SESSION['role']) ) {
            throw new \Exception("User not logged in");
        }
        
        return $_SESSION['id'];
    }
}
