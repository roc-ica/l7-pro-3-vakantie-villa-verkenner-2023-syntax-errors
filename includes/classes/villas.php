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
            $sql .= " AND villaOpties.`ligging.id` = :liggingsoptie";
            $params['liggingsoptie'] = $filters['liggingsoptie'];
        }
    
        if (!empty($filters['eigenschap'])) {
            $sql .= " AND villaEigenschappen.`eigenschap.id` = :eigenschap";
            $params['eigenschap'] = $filters['eigenschap'];
        }
    
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}  