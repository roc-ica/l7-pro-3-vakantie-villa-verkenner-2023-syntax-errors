<?php

class Villas
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getVillas()
    {
        $sql = "SELECT * FROM villa WHERE is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVilla($id)
    {
        $sql = "SELECT * FROM villa WHERE id = :id AND is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVillaImages($id)
    {
        $sql = "SELECT * FROM villaImages WHERE villa = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrimaryImage($id)
    {
        $sql = "SELECT image FROM villaImages WHERE villa = :id AND `primary` = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getVillaEigenschappen($villaId) {
        $query = "
            SELECT e.name 
            FROM villaEigenschappen ve
            JOIN eigenschappen e ON ve.`eigenschap.id` = e.id
            WHERE ve.`villa.id` = ?
        ";
    
        $stmt = $this->db->pdo->prepare($query);
        $stmt->execute([$villaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getVillaOpties($villaId) {
    //     $query = "
    //         SELECT o.name 
    //         FROM villaOpties vo
    //         JOIN ligging_opties o ON vo.`ligging_optie_id` = o.id
    //         WHERE vo.`villa_id` = ?
    //     ";
    //     $stmt = $this->db->pdo->prepare($query);
    //     $stmt->execute([$villaId]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    
}
