<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Model\Article;

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php?error=Vous devez être connecté.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../blog.php');
    exit;
}

$titre = trim($_POST['titre']);
$theme = $_POST['theme'];
$contenu = trim($_POST['contenu']);
$userId = $_SESSION['user']['id'];


if (empty($titre) || empty($contenu) || empty($theme)) {
    header('Location: ../create_article.php?error=Veuillez remplir tous les champs');
    exit;
}

$imageUrl = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $filename = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed) && $fileSize < 5000000) {
        $newName = uniqid('article_', true) . '.' . $ext;
        $destination = $uploadDir . $newName;

        if (move_uploaded_file($fileTmp, $destination)) {
            $imageUrl = 'assets/uploads/articles/' . $newName;
        } else {
            header('Location: ../create_article.php?error=Erreur lors de l\'upload de l\'image');
            exit;
        }
    }
}


$database = new Database();
$conn = $database->getConnection();

if (Article::create($conn, $titre, $contenu, $imageUrl, $theme, $userId)) {
    header('Location: ../blog.php?success=Article publié avec succès !');
    exit;
} else {
    header('Location: ../create_article.php?error=Erreur lors de l\'enregistrement');
    exit;
}
