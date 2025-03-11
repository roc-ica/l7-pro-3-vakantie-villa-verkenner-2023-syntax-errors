<?php

class Villas {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getVillas() {
        $sql = "SELECT * FROM villa";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getVilla($id) {
        $sql = "SELECT * FROM villa WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

}