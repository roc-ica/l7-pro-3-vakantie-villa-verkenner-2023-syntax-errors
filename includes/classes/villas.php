<?php

class Villas {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // public function getVillas() {
    //     $sql = "SELECT * FROM villa WHERE is_deleted = 0";
    //     $stmt = $this->db->pdo->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getVilla($id) {
        $sql = "SELECT * FROM villa WHERE id = :id AND is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVillaImages($id) {
        $sql = "SELECT * FROM villaImages WHERE villa = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPrimaryImage($id) {
        $sql = "SELECT image FROM villaImages WHERE villa = :id AND `primary` = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }
    public function getVillas($filters = []) {
        $sql = "SELECT DISTINCT villa.* FROM villa 
                LEFT JOIN villaEigenschappen ON villa.id = villaEigenschappen.`villa.id`
                LEFT JOIN villaOpties ON villa.id = villaOpties.`villa.id`
                WHERE villa.is_deleted = 0";
    
        $params = [];
    
        if (!empty($filters['name'])) {
            $sql .= " AND villa.name LIKE :name";
            $params['name'] = '%' . $filters['name'] . '%';
        }
    
        if (!empty($filters['min_price'])) {
            $sql .= " AND villa.price >= :min_price";
            $params['min_price'] = $filters['min_price'];
        }
    
        if (!empty($filters['max_price'])) {
            $sql .= " AND villa.price <= :max_price";
            $params['max_price'] = $filters['max_price'];
        }
    
        if (!empty($filters['liggingsoptie'])) {
            $placeholders = implode(',', array_fill(0, count($filters['liggingsoptie']), '?'));
            $sql .= " AND villaOpties.`ligging.id` IN ($placeholders)";
            $params = array_merge($params, $filters['liggingsoptie']);
        }
    
        if (!empty($filters['eigenschap'])) {
            $placeholders = implode(',', array_fill(0, count($filters['eigenschap']), '?'));
            $sql .= " AND villaEigenschappen.`eigenschap.id` IN ($placeholders)";
            $params = array_merge($params, $filters['eigenschap']);
        }
    
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVilla($name, $price, $postal, $street, $number, $desc) {
        $sql = "INSERT INTO villa (name, price, postal, street, number, `desc`, is_deleted) VALUES (:name, :price, :postal, :street, :number, :desc, 0)";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'price' => $price,
            'postal' => $postal,
            'street' => $street,
            'number' => $number,
            'desc' => $desc
        ]);
    }

    public function updateVilla($id, $name, $price, $postal, $street, $number, $desc) {
        $sql = "UPDATE villa SET name = :name, price = :price, postal = :postal, street = :street, number = :number, `desc` = :desc WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'postal' => $postal,
            'street' => $street,
            'number' => $number,
            'desc' => $desc
        ]);
    }

    public function deleteVilla($id) {
        $sql = "UPDATE villa SET is_deleted = 1 WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function addVillaEigenschappen($villa_id, $eigenschap_ids) {
        $sqlDelete = "DELETE FROM villaEigenschappen WHERE `villa.id` = :villa_id";
        $stmtDelete = $this->db->pdo->prepare($sqlDelete);
        $stmtDelete->execute(['villa_id' => $villa_id]);

        $sqlInsert = "INSERT INTO villaEigenschappen (`villa.id`, `eigenschap.id`) VALUES (:villa_id, :eigenschap_id)";
        $stmtInsert = $this->db->pdo->prepare($sqlInsert);
        foreach ($eigenschap_ids as $eigenschap_id) {
            $stmtInsert->execute([
                'villa_id' => $villa_id,
                'eigenschap_id' => $eigenschap_id
            ]);
        }
    }

    public function addVillaOpties($villa_id, $optie_ids) {
        $sqlDelete = "DELETE FROM villaOpties WHERE `villa.id` = :villa_id";
        $stmtDelete = $this->db->pdo->prepare($sqlDelete);
        $stmtDelete->execute(['villa_id' => $villa_id]);

        $sqlInsert = "INSERT INTO villaOpties (`villa.id`, `ligging.id`) VALUES (:villa_id, :optie_id)";
        $stmtInsert = $this->db->pdo->prepare($sqlInsert);
        foreach ($optie_ids as $optie_id) {
            $stmtInsert->execute([
                'villa_id' => $villa_id,
                'optie_id' => $optie_id
            ]);
        }
    }
}
