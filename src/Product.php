<?php
class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createProduct($userId, $name, $description, $price) {
        $stmt = $this->db->prepare("INSERT INTO products (user_id, name, description, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $name, $description, $price]);
    }

    public function getProduct($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
