<?php

class Items {
    private $item_id;
    private $name;
    private $price;
    private $description;
    private $batch_id;
    private $db_conn;

    public function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect;
        $this->db_conn = $db->connect();
    }

    public function get_item_id() {
        return $this->item_id;
    }

    public function set_item_id($id) {
        $this->item_id = $id;
    }

    public function get_name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function get_price() {
        return $this->price;
    }

    public function set_price($price) {
        $this->price = $price;
    }

    public function get_description() {
        return $this->description;
    }

    public function set_description($desc) {
        $this->description = $desc;
    }

    public function get_batch_id() {
        return $this->batch_id;
    }

    public function set_batch_id($id) {
        $this->batch_id = $id;
    }

    public function get_all_items() {
        try {
            $stmt = $this->db_conn->prepare('SELECT * FROM items');
            if($stmt->execute()) {
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $items;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_items_user($user_id) {

        try {

            $stmt = $this->db_conn->prepare(
                "SELECT * FROM items WHERE items.item_id IN (SELECT invoices.item_id FROM invoices WHERE invoices.user_id = :uid AND (invoices.status = 'paid' OR invoices.status = 'pending') )"
            );
            
            $stmt->bindParam(":uid", $user_id);

            if($stmt->execute()) {
                $item = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $item;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get_not_taken_items($user_id) {
        try {

            $stmt = $this->db_conn->prepare(
                "SELECT * FROM items WHERE items.item_id NOT IN (SELECT invoices.item_id FROM invoices WHERE invoices.user_id = :uid AND (invoices.status = 'paid' OR invoices.status = 'pending') )"
            );
            
            $stmt->bindParam(":uid", $user_id);

            if($stmt->execute()) {
                $item = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $item;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}