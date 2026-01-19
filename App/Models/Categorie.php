<?php
namespace App\Models;
use PDO;

class Categorie
{
    public static function getAll($conn)
    {
        $query = "SELECT * FROM categories ORDER BY nom ASC";
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getById($conn, $id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
