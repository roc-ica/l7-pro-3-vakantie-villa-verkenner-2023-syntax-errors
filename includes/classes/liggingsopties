<?php

class Liggingsopties {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getLiggingsopties() {
        $sql = "SELECT * FROM ligging_opties";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLiggingsoptie($id) {
        $sql = "SELECT * FROM ligging_opties WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}