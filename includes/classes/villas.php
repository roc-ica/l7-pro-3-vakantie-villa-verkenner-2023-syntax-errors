<?php

class Villas {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getVillas() {
        $sql = "SELECT * FROM villas";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}