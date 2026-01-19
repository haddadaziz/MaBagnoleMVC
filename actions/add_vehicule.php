<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/database.php';

use App\Database;
use App\Models\Vehicule;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $database = new Database();
    $conn = $database->getConnection();

    $target_dir = "../uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // crre nom unique pour pour éviter les doublons
    $file_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $image_url_bdd = "uploads/" . $file_name;

        $data = [
            'marque' => htmlspecialchars($_POST['marque']),
            'modele' => htmlspecialchars($_POST['modele']),
            'prix_journalier' => floatval($_POST['prix']),
            'categorie_id' => intval($_POST['categorie_id']),
            'image_url' => $image_url_bdd
        ];

        if (Vehicule::add($conn, $data)) {
            header("Location: ../admin_vehicules.php?status=success_add_vehicle");
            exit();
        }
    }

}