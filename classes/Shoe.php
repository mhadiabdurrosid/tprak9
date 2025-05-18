<?php
require_once 'Database.php';

class Shoe {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM shoes ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM shoes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO shoes (brand, model, size, price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['brand'], 
            $data['model'], 
            $data['size'], 
            $data['price']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE shoes SET brand = ?, model = ?, size = ?, price = ? WHERE id = ?");
        return $stmt->execute([
            $data['brand'], 
            $data['model'], 
            $data['size'], 
            $data['price'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM shoes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
