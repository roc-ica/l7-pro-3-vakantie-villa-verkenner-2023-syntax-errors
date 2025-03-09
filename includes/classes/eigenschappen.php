<?php

class Eigenschappen {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getEigenschappen() {
        $sql = "SELECT * FROM eigenschappen";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEigenschap($id) {
        $sql = "SELECT * FROM eigenschappen WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getEigenschappenByVilla($villa_id) {
        $sql = "SELECT * FROM villaEigenschappen WHERE `villa.id` = :villa_id";
        $sql2 = "SELECT * FROM eigenschappen WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
        $eigenschappen = $stmt->fetchAll();
        $result = [];
        foreach ($eigenschappen as $eigenschap) {
            $stmt = $this->db->pdo->prepare($sql2);
            $stmt->execute(['id' => $eigenschap->{'eigenschap.id'}]);
            $result[] = $stmt->fetch();
        }
        return $result;
    }
}