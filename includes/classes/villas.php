<?php

class Villas
{

    private $db;
    private $liggingsopties;
    private $options;

    public function __construct()
    {
        $this->db = new Database();
        $this->liggingsopties = new Liggingsopties();
        $this->options = new Eigenschappen();
    }

    // public function getVillas() {
    //     $sql = "SELECT * FROM villa WHERE is_deleted = 0";
    //     $stmt = $this->db->pdo->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll();
    // }

    public function getVilla($id)
    {
        $sql = "SELECT * FROM villa WHERE id = :id AND is_deleted = 0";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getVillaImages($id)
    {
        $sql = "SELECT * FROM villaImages WHERE villa = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function getPrimaryImage($id)
    {
        $sql = "SELECT image FROM villaImages WHERE villa = :id AND `primary` = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }
    public function getVillas($filters = [])
    {
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

    public function addVilla($post, $files)
    {
        $sql = "INSERT INTO villa (name, price, postal, street, number, `desc`) VALUES (:name, :price, :postal, :street, :number, :desc)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([
            'name' => $post['name'],
            'price' => $post['price'],
            'postal' => $post['postal'],
            'street' => $post['street'],
            'number' => $post['number'],
            'desc' => $post['desc']
        ]);

        $villa_id = $this->db->pdo->lastInsertId();

        // add ligings opties
        if (isset($post['opties'])) {
            $this->liggingsopties->addVillaOpties($villa_id, $post['opties']);
        }
        // add eigenschappen
        if (isset($post['eigenschappen'])) {
            $this->options->addVillaEigenschappen($villa_id, $post['eigenschappen']);
        }
        // upload images
        if (isset($files['images'])) {
            $this->uploadVillaImages($villa_id, $files['images'], $post['primary'] ?? null);
        }

    }

    public function updateVilla($id, $post, $files)
    {
        $sql = "UPDATE villa SET name = :name, price = :price, postal = :postal, street = :street, number = :number, `desc` = :desc WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'name' => $post['name'],
            'price' => $post['price'],
            'postal' => $post['postal'],
            'street' => $post['street'],
            'number' => $post['number'],
            'desc' => $post['desc']
        ]);

        // Opties (ligging)
        $this->liggingsopties->deleteLiggingsoptieByVillaId($id);
        $this->liggingsopties->addVillaOpties($id, $post['opties'] ?? []);

        // Eigenschappen
        $this->options->deleteEigenschappenByVillaId($id);
        $this->options->addVillaEigenschappen($id, $post['eigenschappen'] ?? []);


        // Nieuwe afbeeldingen uploaden
        if (isset($files['images'])) {
            $this->uploadVillaImages($id, $files['images'], $post['primary'] ?? null);
        }

        // Primary afbeelding bijwerken
        if (isset($post['set_primary'])) {
            $this->setPrimaryImage($post['set_primary']);
        }

        // Oude afbeeldingen verwijderen
        if (isset($post['delete_image']) && is_array($post['delete_image'])) {
            foreach ($post['delete_image'] as $imgId) {
                $this->deleteVillaImage($imgId);
            }
        }
    }

    public function deleteVilla($id)
    {
        $sql = "UPDATE villa SET is_deleted = 1 WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function uploadVillaImages($villa_id, $images, $primaryIndex = null)
    {
        foreach ($images['tmp_name'] as $index => $tmpName) {
            $filename = uniqid('villaimg-') . '-' . basename($images['name'][$index]);
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/villa/';
            move_uploaded_file($tmpName, $uploadDir . $filename);

            $is_primary = ($primaryIndex !== null && $primaryIndex == $index) ? 1 : 0;

            if ($is_primary) {
                $this->clearPrimaryImage($villa_id);
            }

            $sql = "INSERT INTO villaImages (villa, image, `primary`) VALUES (:villa, :image, :primary)";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->execute([
                'villa' => $villa_id,
                'image' => $filename,
                'primary' => $is_primary
            ]);
        }
    }

    public function setPrimaryImage($image_id)
    {
        $sql = "SELECT villa FROM villaImages WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $image_id]);
        $villa_id = $stmt->fetchColumn();

        $this->clearPrimaryImage($villa_id);

        $sql = "UPDATE villaImages SET `primary` = 1 WHERE id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['id' => $image_id]);
    }

    private function clearPrimaryImage($villa_id)
    {
        $sql = "UPDATE villaImages SET `primary` = 0 WHERE villa = :villa";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute(['villa' => $villa_id]);
    }

    public function deleteVillaImage($image_id)
    {
        // Optional: verwijder fysieke file ook
        $stmt = $this->db->pdo->prepare("SELECT image FROM villaImages WHERE id = :id");
        $stmt->execute(['id' => $image_id]);
        $filename = $stmt->fetchColumn();

        if ($filename && file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/img/villa/" . $filename)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/assets/img/villa/" . $filename);
        }

        $stmt = $this->db->pdo->prepare("DELETE FROM villaImages WHERE id = :id");
        $stmt->execute(['id' => $image_id]);
    }

}
