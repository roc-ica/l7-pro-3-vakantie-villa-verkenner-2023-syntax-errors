<?php

class Eigenschappen
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getEigenschappen()
    {
        $sql = "SELECT * FROM eigenschappen";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEigenschap($id)
    {
        $sql = "SELECT * FROM eigenschappen WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getEigenschappenByVilla($villa_id)
    {
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

    public function getSelectedEigenschappen($villa_id)
    {
        $sql = "SELECT `eigenschap.id` FROM villaEigenschappen WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
        return array_column($stmt->fetchAll(), 'eigenschap.id');
    }

    public function addEigenschap($name)
    {
        $sql = "INSERT INTO eigenschappen (name) VALUES (:name)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
    }

    public function updateEigenschap($id, $name)
    {
        $sql = "UPDATE eigenschappen SET name = :name WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $name
        ]);
    }

    public function deleteEigenschappenByVillaId($villa_id)
    {
        $sql = "DELETE FROM villaEigenschappen WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
    }

    public function addVillaEigenschappen($villa_id, $eigenschap_ids)
    {
        $sql = "INSERT INTO villaEigenschappen (`villa.id`, `eigenschap.id`) VALUES (:villa_id, :eigenschap_id)";
        $stmt = $this->db->pdo->prepare($sql);
        foreach ($eigenschap_ids as $eigenschap_id) {
            $stmt->execute([
                'villa_id' => $villa_id,
                'eigenschap_id' => $eigenschap_id
            ]);
        }
    }

    public function deleteEigenschap($id)
    {
        $sql = "DELETE FROM eigenschappen WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
