<?php

class Liggingsopties
{

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLiggingsopties()
    {
        $sql = "SELECT * FROM ligging_opties";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getLiggingsoptie($id)
    {
        $sql = "SELECT * FROM ligging_opties WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getliggingsoptiesByVilla($villa_id)
    {
        $sql = "SELECT * FROM villaOpties WHERE `villa.id` = :villa_id";
        $sql2 = "SELECT * FROM ligging_opties WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
        $opties = $stmt->fetchAll();

        $result = [];
        foreach ($opties as $optie) {
            $stmt = $this->db->pdo->prepare($sql2);
            $stmt->execute(['id' => $optie->{'ligging.id'}]);
            $result[] = $stmt->fetch();
        }
        return $result;
    }

    public function getSelectedOpties($villa_id)
    {
        $sql = "SELECT `ligging.id` FROM villaOpties WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
        return array_column($stmt->fetchAll(), 'ligging.id');
    }

    public function addLiggingsoptie($name)
    {
        $sql = "INSERT INTO ligging_opties (name) VALUES (:name)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
    }

    public function updateLiggingsoptie($id, $name)
    {
        $sql = "UPDATE ligging_opties SET name = :name WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'id' => $id]);
    }

    public function deleteLiggingsoptie($id)
    {
        $sql = "DELETE FROM ligging_opties WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function deleteLiggingsoptieByVillaId($villa_id)
    {
        $sql = "DELETE FROM villaOpties WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
    }

    public function addVillaOpties($villa_id, $ligging_ids)
    {
        $sql = "INSERT INTO villaOpties (`villa.id`, `ligging.id`) VALUES (:villa_id, :ligging_id)";
        $stmt = $this->db->pdo->prepare($sql);
        foreach ($ligging_ids as $ligging_id) {
            $stmt->execute([
                'villa_id' => $villa_id,
                'ligging_id' => $ligging_id
            ]);
        }
    }

}
