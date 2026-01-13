<?php
namespace App\Model;
use PDO;

class Article {
    public static function create($conn, $titre, $contenu, $imageUrl, $theme, $userId) {
        $sql = "INSERT INTO articles (titre, contenu, image_url, theme, user_id) 
                VALUES (:titre, :contenu, :img, :theme, :uid)";
        
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':titre'   => $titre,
            ':contenu' => $contenu,
            ':img'     => $imageUrl,
            ':theme'   => $theme,
            ':uid'     => $userId
        ]);
    }

    public static function getAll($conn) {
        $sql = "SELECT a.*, u.nom_complet as auteur 
                FROM articles a
                JOIN users u ON a.user_id = u.id
                ORDER BY a.date_creation DESC";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        public static function getById($conn, $id) {
        $sql = "SELECT a.*, u.nom_complet as auteur 
                FROM articles a
                JOIN users u ON a.user_id = u.id
                WHERE a.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}