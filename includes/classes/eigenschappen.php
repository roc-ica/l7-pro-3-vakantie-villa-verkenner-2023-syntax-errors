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
            $row = $stmt->fetch();  // Dit geeft een stdClass-object
            if ($row) {
                // Voeg nu enkel de id toe in plaats van het volledige object
                $result[] = $row->id;
            }
        }
        return $result;
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
        $stmt->execute(['name' => $name, 'id' => $id]);
    }

    public function deleteEigenschap($id)
    {
        $sql = "DELETE FROM eigenschappen WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function deleteEigenschapByVilla($villa_id, $eigenschap_id)
    {
        $sql = "DELETE FROM villaEigenschappen WHERE `villa.id` = :villa_id AND `eigenschap.id` = :eigenschap_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id, 'eigenschap_id' => $eigenschap_id]);
    }

    public function deleteVillaEigenschappen($villa_id)
    {
        $sql = "DELETE FROM villaEigenschappen WHERE `villa.id` = :villa_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa_id' => $villa_id]);
    }

    public function addEigenschapToVilla($villa_id, $eigenschap_id)
    {
        $sql = "INSERT INTO villaEigenschappen (`villa.id`, `eigenschap.id`) VALUES (:villa_id, :eigenschap_id)";
        $stmt = $this->db->pdo->prepare($sql);
        foreach ($eigenschap_id as $id) {
            $stmt->execute(['villa_id' => $villa_id, 'eigenschap_id' => $id]);
        }
    }
}