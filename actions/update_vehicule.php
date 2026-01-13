<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Database;
use App\Model\Vehicule;
$id = $_POST['id'] ?? null;
$marque = trim($_POST['marque']);
$modele = trim($_POST['modele']);
$prix = $_POST['prix'];
$categorie_id = $_POST['categorie_id'];

if (empty($id) || empty($marque) || empty($modele) || empty($prix)) {
    header('Location: ../admin_vehicules.php?status=error_champs_manquants');
    exit;
}

$imageUrl = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $filename = $_FILES['image']['name'];
    $fileSize = $_FILES['image']['size'];
    $fileTmp = $_FILES['image']['tmp_name'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if ($fileSize < 5000000) {
            $newName = uniqid('vehicule_', true) . "." . $ext;

            $uploadDir = __DIR__ . '/../assets/uploads/vehicules/';
            $destination = $uploadDir . $newName;

            if (move_uploaded_file($fileTmp, $destination)) {
                $imageUrl = 'assets/uploads/vehicules/' . $newName;
            } else {
                header('Location: ../admin_vehicules.php?status=error_upload_failed');
                exit;
            }
        } else {
            header('Location: ../admin_vehicules.php?status=error_file_too_big');
            exit;
        }
    } else {
        header('Location: ../admin_vehicules.php?status=error_format_invalid');
        exit;
    }
}

$database = new Database();
$conn = $database->getConnection();

$result = Vehicule::update($conn, $id, $marque, $modele, $prix, $categorie_id, $imageUrl);

if ($result) {
    header('Location: ../admin_vehicules.php?status=success_modifier_vehicule');
} else {
    header('Location: ../admin_vehicules.php?status=echec_modifier_vehicule');
}
exit;