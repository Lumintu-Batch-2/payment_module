<?php

class Invoices {
    private $order_id;
    private $first_name;
    private $last_name;
    private $email;
    private $phone;
    private $status;
    private $date_created;
    private $transaction_id;
    private $user_id;
    private $item_id;
    private $amount;
    private $db_conn;

    public function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect;
        $this->db_conn = $db->connect();
    }

    public function get_order_id() {
        return $this->order_id;
    }

    public function set_order_id($id) {
        $this->order_id = $id;
    }

    public function get_first_name() {
        return $this->first_name;
    }

    public function set_first_name($first_name) {
        $this->first_name = $first_name;
    }

    public function get_last_name() {
        return $this->last_name;
    }

    public function set_last_name($last_name) {
        $this->last_name = $last_name;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_email($email) {
        $this->email = $email;
    }

    public function get_phone() {
        return $this->phone;
    }

    public function set_phone($phone) {
        $this->phone = $phone;
    }

    public function get_status() {
        return $this->status;
    }

    public function set_status($status) {
        $this->status = $status;
    }

    public function get_date_created() {
        return $this->date_created;
    }

    public function set_date_created($date) {
        $this->date_created = $date;
    }

    public function get_transaction_id() {
        return $this->transaction_id;
    }

    public function set_transaction_id($id) {
        $this->transaction_id = $id;
    }

    public function get_user_id() {
        return $this->user_id;
    }

    public function set_user_id($id) {
        $this->user_id = $id;
    }

    public function get_item_id() {
        return $this->item_id;
    }

    public function set_item_id($id) {
        $this->item_id = $id;
    }

    public function get_amount() {
        return $this->amount;
    }

    public function set_amount($amount) {
        $this->amount = $amount;
    }

    public function create_invoice() {

        try {
            $stmt = $this->db_conn->prepare(
                'INSERT INTO invoices(first_name, last_name, email, phone, status, date_created, transaction_id, user_id, item_id, amount) 
                VALUES(:first_name, :last_name, :email, :phone, :status, :date_created, :transaction_id, :user_id, :item_id, :amount)'
                );
    
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":date_created", $this->date_created);
            $stmt->bindParam(":transaction_id", $this->transaction_id);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":item_id", $this->item_id);
            $stmt->bindParam(":amount", $this->amount);

            if($stmt->execute()) {
                return $this->db_conn->lastInsertId();
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }

    public function update_snap_token() {
        try {

            $stmt = $this->db_conn->prepare(
                'UPDATE invoices SET transaction_id = :transaction_id WHERE order_id= :order_id'
            );
    
            $stmt->bindParam(":transaction_id", $this->transaction_id);
            $stmt->bindParam(":order_id", $this->order_id);
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function update_status() {
        try {
            $stmt = $this->db_conn->prepare(
                'UPDATE invoices SET status = :status WHERE order_id = :order_id'
            );

            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":order_id", $this->order_id);

            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_invoice() {
        try {
            $stmt = $this->db_conn->prepare(
                'SELECT * FROM invoices WHERE order_id = :order_id'
            );

            $stmt->bindParam(":order_id", $this->order_id);

            if($stmt->execute()) {
                $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
                return $invoice;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_all_invoices() {
        try {
            $stmt = $this->db_conn->prepare(
                'SELECT * FROM invoices'
            );
            if($stmt->execute()) {
                $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $invoices;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_invoices_user() {
        try {
            $stmt = $this->db_conn->prepare(
                'SELECT * FROM invoices WHERE user_id = :user_id'
            );
            $stmt->bindParam(":user_id", $this->user_id);

            if($stmt->execute()) {
                $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $invoices;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}