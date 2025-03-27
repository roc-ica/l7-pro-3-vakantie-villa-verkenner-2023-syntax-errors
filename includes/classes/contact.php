<?php

class Contact {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getContacts() {
        $sql = "SELECT * FROM contact";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getContact($id) {
        $sql = "SELECT * FROM contact WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function addContact($naam, $email, $villa, $vraag) {
        $sql = "INSERT INTO contact (naam, email, villa, vraag) VALUES (:naam, :email, :villa, :vraag)";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'naam' => $naam,
            'email' => $email,
            'villa' => $villa,
            'vraag' => $vraag
        ]);
    }

    public function updateContact($id, $naam, $email, $villa, $vraag) {
        $sql = "UPDATE contact SET naam = :naam, email = :email, villa = :villa, vraag = :vraag WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'naam' => $naam,
            'email' => $email,
            'villa' => $villa,
            'vraag' => $vraag
        ]);
    }

    public function deleteContact($id) {
        $sql = "DELETE FROM contact WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
