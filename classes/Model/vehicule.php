<?php
namespace App\Model;
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
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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

    public static function add($conn, $data)
    {
        $query = "INSERT INTO vehicules (marque, modele, prix_journalier, image_url, categorie_id) 
                  VALUES (:marque, :modele, :prix, :img, :cat_id)";

        $stmt = $conn->prepare($query);

        return $stmt->execute([
            ':marque' => $data['marque'],
            ':modele' => $data['modele'],
            ':prix' => $data['prix_journalier'],
            ':img' => $data['image_url'],
            ':cat_id' => $data['categorie_id']
        ]);
    }


    public static function update($conn, $id, $marque, $modele, $prix, $categorie_id, $imageUrl = null)
    {
        if ($imageUrl) {
            $sql = "UPDATE vehicules SET marque=?, modele=?, prix_journalier=?, categorie_id=?, image_url=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([$marque, $modele, $prix, $categorie_id, $imageUrl, $id]);
        } else {
            $sql = "UPDATE vehicules SET marque=?, modele=?, prix_journalier=?, categorie_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([$marque, $modele, $prix, $categorie_id, $id]);
        }
    }

    public static function delete($conn, $id)
    {
        $sqlGet = "SELECT image_url FROM vehicules WHERE id = :id";
        $stmtGet = $conn->prepare($sqlGet);
        $stmtGet->execute([':id' => $id]);
        $vehicule = $stmtGet->fetch();

        if ($vehicule && $vehicule['image_url']) {
            $fichier = __DIR__ . '/../../' . $vehicule['image_url'];
            if (file_exists($fichier)) {
                unlink($fichier);
            }
        }

        $query = "DELETE FROM vehicules WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}