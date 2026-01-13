<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Database;
use App\Model\Vehicule;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    
    $database = new Database();
    $conn = $database->getConnection();
    
    $id = $_POST['id'];

    if (Vehicule::delete($conn, $id)) {
        header('Location: ../admin_vehicules.php?status=succes_delete_vehicule');
    }
}
exit;