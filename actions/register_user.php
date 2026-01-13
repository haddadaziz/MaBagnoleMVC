<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Model\User;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (empty($nom) || empty($email) || empty($password) || empty($confirm_password)) {
    header('Location: ../register.php?status=all_field_required');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../register.php?status=invalid_email_format');
    exit;
}

if ($password !== $confirm_password) {
    header('Location: ../register.php?status=pwd_dont_match');
    exit;
}

if (strlen($password) < 6) {
    header('Location: ../register.php?status=pwd_too_short');
    exit;
}

$database = new Database();
$conn = $database->getConnection();

if (User::findByEmail($conn, $email)) {
    header('Location: ../register.php?status=email_already_taken');
    exit;
}


if (User::register($conn, $nom, $email, $password)) {
    header('Location: ../login.php?status=success_register');
    exit;
} else {
    header('Location: ../register.php?error_register');
    exit;
}
exit;