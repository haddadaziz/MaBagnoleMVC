<?php
namespace App\Model;

use PDO;

class Reservation {
    public static function create($conn, $userId, $vehiculeId, $dateDebut, $dateFin, $lieuDepart, $lieuRetour, $prixTotal) {
        
        if (!self::isAvailable($conn, $vehiculeId, $dateDebut, $dateFin)) {
            return false;
        }

        $sql = "INSERT INTO reservations (user_id, vehicule_id, date_debut, date_fin, lieu_depart, lieu_retour, prix_total, statut) 
                VALUES (:user, :vehicule, :debut, :fin, :depart, :retour, :prix, 'En attente')";
        
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':user'     => $userId,
            ':vehicule' => $vehiculeId,
            ':debut'    => $dateDebut,
            ':fin'      => $dateFin,
            ':depart'   => $lieuDepart,
            ':retour'   => $lieuRetour,
            ':prix'     => $prixTotal
        ]);
    }

    public static function getAll($conn) {
        $sql = "SELECT 
                    r.*, 
                    u.nom_complet as client_nom, 
                    u.email as client_email,
                    v.marque, 
                    v.modele,
                    v.image_url
                FROM reservations r
                JOIN users u ON r.user_id = u.id
                JOIN vehicules v ON r.vehicule_id = v.id
                ORDER BY r.date_debut DESC";

        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getMyReservations($conn, $userId) {
        $sql = "SELECT 
                    r.*, 
                    v.marque, 
                    v.modele, 
                    v.image_url,
                    v.prix_journalier
                FROM reservations r
                JOIN vehicules v ON r.vehicule_id = v.id
                WHERE r.user_id = :id
                ORDER BY r.date_debut DESC";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updateStatus($conn, $id, $nouveauStatut) {
        $sql = "UPDATE reservations SET statut = :statut WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':statut' => $nouveauStatut,
            ':id'     => $id
        ]);
    }

    public static function isAvailable($conn, $vehiculeId, $debut, $fin) {
        $sql = "SELECT COUNT(*) FROM reservations 
                WHERE vehicule_id = :id 
                AND statut = 'Confirmée'
                AND (
                    (date_debut <= :fin AND date_fin >= :debut)
                )";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id'    => $vehiculeId,
            ':debut' => $debut,
            ':fin'   => $fin
        ]);
        
        return $stmt->fetchColumn() == 0;
    }
    
    //  stats
    public static function getTotalRevenue($conn) {
        $sql = "SELECT SUM(prix_total) FROM reservations WHERE statut = 'Confirmée'";
        $stmt = $conn->query($sql);
        return $stmt->fetchColumn() ?: 0;
    }
}