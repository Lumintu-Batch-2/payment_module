<?php

class DbConnect {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db_name = "payment_db";
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->db_name, $this->user,$this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public function close() {
        $this->conn = null;
    }
}