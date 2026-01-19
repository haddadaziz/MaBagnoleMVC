<?php
namespace App\Models;
use PDO;

class Vehicule
{
    public static function getById($conn, $id) {
        $sql = "SELECT v.*, c.nom as nom_categorie 
                FROM vehicules v
                LEFT JOIN categories c ON v.categorie_id = c.id
                WHERE v.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll($conn, $search = null, $categorie_id = null)
    {
        $query = "SELECT v.*, c.nom AS nom_categorie 
              FROM vehicules v
              LEFT JOIN categories c ON v.categorie_id = c.id";
        $params = [];
        if (!empty($search)) {
            $query .= " AND (v.marque LIKE :search OR v.modele LIKE :search)";
            $params[':search'] = "%$search%";
        }
        if (!empty($categorie_id)) {
            $query .= " AND v.categorie_id = :cat_id";
            $params[':cat_id'] = $categorie_id;
        }
        $query .= " ORDER BY v.id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
