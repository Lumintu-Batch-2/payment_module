<?php

class Payments {
    private $payment_id;
    private $order_id;
    private $amount;
    private $payment_date;
    private $payment_type;
    private $status;
    private $db_conn;

    public function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect;
        $this->db_conn = $db->connect();
    }

    public function get_payment_id() {
        return $this->payment_id;
    }

    public function set_payment_id($id) {
        $this->payment_id = $id;
    }

    public function get_order_id() {
        return $this->order_id;
    }

    public function set_order_id($id) {
        $this->order_id = $id;
    }

    public function get_amount() {
        return $this->amount;
    }

    public function set_amount($amount) {
        $this->amount = $amount;
    }

    public function get_payment_date() {
        return $this->payment_date;
    }

    public function set_payment_date($date) {
        $this->payment_date = $date;
    }

    public function get_payment_type() {
        return $this->payment_type;
    }

    public function set_payment_type($type) {
        $this->payment_type = $type;
    }

    public function get_status() {
        return $this->status;
    }

    public function set_status($status) {
        $this->status = $status;
    }

    public function create_payment() {
        try {

            $stmt = $this->db_conn->prepare(
                'INSERT INTO payments(order_id, amount, payment_date, payment_type, status) VALUES(:order_id, :amount, :payment_date, :payment_type, :status)'
            );
    
            $stmt->bindParam(":order_id", $this->order_id);
            $stmt->bindParam(":amount", $this->amount);
            $stmt->bindParam(":payment_date", $this->payment_date);
            $stmt->bindParam(":payment_type", $this->payment_type);
            $stmt->bindParam(":status", $this->status);

            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }

    public function payment_check() {
        try {

            $stmt = $this->db_conn->prepare(
                'SELECT * FROM payments WHERE order_id = :order_id'
            );
    
            $stmt->bindParam(":order_id", $this->order_id);
    
            if($stmt->execute()) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data;
            } else {
                return null;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update_payment_status() {
        try {

            $stmt = $this->db_conn->prepare(
                'UPDATE payments SET status = :status WHERE order_id = :order_id'
            );
    
            $stmt->bindParam(":order_id", $this->order_id);
            $stmt->bindParam(":status", $this->status);
    
            if($stmt->execute()) {
                return true;
            } else {
                return null;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
}