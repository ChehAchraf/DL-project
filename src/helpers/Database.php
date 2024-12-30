<?php

    namespace Helpers;

    class Database {
        private $host = 'localhost'; 
        private $dbname = 'd&l'; 
        private $username = 'root'; 
        private $password = ''; 
        private $pdo;

        public function __construct() {
            try {
                $this->pdo = new \PDO("mysql:host=$this->host;dbname=$this->dbname;connect_timeout=10", $this->username, $this->password);
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $mekka) {
                echo "Connection failed: " . $mekka->getMessage();
            }
        }

        public function getConnection() {
            return $this->pdo;
        }
    }
    ?>

