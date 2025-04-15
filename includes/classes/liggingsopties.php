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

    public function getliggingsoptiesByVilla($villa_id) {
    $sql = "SELECT * FROM villaOpties WHERE `villa.id` = :villa_id";
    $sql2 = "SELECT * FROM ligging_opties WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute(['villa_id' => $villa_id]);
    $opties = $stmt->fetchAll();
    
    $result = [];
    foreach ($opties as $optie) {
        $stmt = $this->db->pdo->prepare($sql2);
        $stmt->execute(['id' => $optie->{'ligging.id'}]);
        $row = $stmt->fetch();  // Dit geeft een stdClass-object
        if ($row) {
            // Voeg nu enkel de id toe in plaats van het volledige object
            $result[] = $row->id;
        }
    }
    return $result;
}

    public function addLiggingsoptie($name) {
        $sql = "INSERT INTO ligging_opties (name) VALUES (:name)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
    }

    public function updateLiggingsoptie($id, $name) {
        $sql = "UPDATE ligging_opties SET name = :name WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'id' => $id]);
    }

    public function deleteLiggingsoptie($id) {
        $sql = "DELETE FROM ligging_opties WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function deleteLiggingsoptieByVilla($villa_id, $liggingsoptie_id) {
        $sql = "DELETE FROM villaOpties WHERE `villa.id` = :villa_id AND `ligging.id` = :liggingsoptie_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id, 'liggingsoptie_id' => $liggingsoptie_id]);
    }

    public function deleteLiggingsoptieByVillaId($villa_id) {
        $sql = "DELETE FROM villaOpties WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
    }

    public function addLiggingsoptieToVilla($villa_id, $liggingsoptie_id) {
        $sql = "INSERT INTO villaOpties (`villa.id`, `ligging.id`) VALUES (:villa_id, :liggingsoptie_id)";
        $stmt = $this->db->pdo->prepare($sql);
        foreach ($liggingsoptie_id as $id) {
            $stmt->execute(['villa_id' => $villa_id, 'liggingsoptie_id' => $id]);
        }
    }

}