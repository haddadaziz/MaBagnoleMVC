<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/database.php';
use App\Database;
use App\Models\User;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = new Database();
    $conn = $db->getConnection();
        
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([':id' => $_POST['id']])) {
        header('Location: ../admin_users.php?success=user_deleted');
    } else {
        header('Location: ../admin_users.php?error=cannot_delete');
    }
} else {
    header('Location: ../admin_users.php');
}