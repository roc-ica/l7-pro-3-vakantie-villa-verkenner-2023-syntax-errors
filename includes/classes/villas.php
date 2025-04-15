<?php

class Villas {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Haalt één villa op (mits niet verwijderd)
    public function getVilla($id) {
        $sql = "SELECT * FROM villa WHERE id = :id AND is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Haalt alle afbeeldingen op voor een villa
    public function getVillaImages($id) {
        $sql = "SELECT * FROM villaImages WHERE villa = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }
    
    // Haalt de primaire afbeelding op voor een villa
    public function getPrimaryImage($id) {
        $sql = "SELECT image FROM villaImages WHERE villa = :id AND `primary` = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getAllVillas() {
        $sql = "SELECT * FROM villa WHERE is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Haalt villa's op met optionele filters
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
        return $stmt->fetchAll();
    }

    public function addVilla($data) {
        $sql = "INSERT INTO villa (name, postal, street, number, `desc`, price, forsale) 
                VALUES (:name, :postal, :street, :number, :desc, :price, :forsale)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([
            'name'    => $data['name'],
            'postal'  => $data['postal'],
            'street'  => $data['street'],
            'number'  => $data['number'],
            'desc'    => $data['desc'],
            'price'   => $data['price'],
            'forsale' => isset($data['forsale']) ? 1 : 0
        ]);
        return $this->db->pdo->lastInsertId();
    }

    public function updateVilla($id, $data) {
        $sql = "UPDATE villa 
                SET name = :name, postal = :postal, street = :street, number = :number, `desc` = :desc, price = :price, forsale = :forsale 
                WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([
            'name'    => $data['name'],
            'postal'  => $data['postal'],
            'street'  => $data['street'],
            'number'  => $data['number'],
            'desc'    => $data['desc'],
            'price'   => $data['price'],
            'forsale' => isset($data['forsale']) ? 1 : 0,
            'id'      => $id
        ]);
    }

    public function deleteVilla($id) {
        $sql = "UPDATE villa SET is_deleted = 1 WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function addVillaImages($villaId, $files, $primaryIndex = null) {
        $total = count($files['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmpFile = $files['tmp_name'][$i];
            if ($tmpFile && is_uploaded_file($tmpFile)) {
                $filename = uniqid() . "_" . basename($files['name'][$i]);
                $destination = "/assets/img/villa/" . $filename;
                if (move_uploaded_file($tmpFile, $destination)) {
                    $isPrimary = ($primaryIndex !== null && $primaryIndex == $i) ? 1 : 0;
                    $sql = "INSERT INTO villaImages (villa, image, `primary`) VALUES (:villa, :image, :primary)";
                    $stmt = $this->db->pdo->prepare($sql);
                    $stmt->execute([
                        'villa'   => $villaId,
                        'image'   => $filename,
                        'primary' => $isPrimary
                    ]);
                }
            }
        }
    }

    public function getVillaPrimaryImage($villaId) {
        $sql = "SELECT primary FROM villaImages WHERE villa = :villa AND `primary` = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa' => $villaId]);
        return $stmt->fetchColumn();
    }

}

?>
