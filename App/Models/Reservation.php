<?php
namespace App\Models;
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

    public static function isAvailable($conn, $vehiculeId, $dateDebut, $dateFin) {
        $sql = "SELECT COUNT(*) FROM reservations WHERE vehicule_id = :vehicule AND (
            (date_debut <= :fin AND date_fin >= :debut)
        ) AND statut != 'Annulée'";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':vehicule' => $vehiculeId,
            ':debut' => $dateDebut,
            ':fin' => $dateFin
        ]);
        return $stmt->fetchColumn() == 0;
    }
}
