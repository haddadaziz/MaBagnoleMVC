<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Database;
use App\Model\Vehicule;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

$database = new Database();
$conn = $database->getConnection();
$voiture = Vehicule::getById($conn, $id);

if (!$voiture) {
    header('Location: index.php?error=Véhicule introuvable');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']) ?> - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#2563EB',
                        primary_hover: '#1D4ED8',
                        dark: '#0F172A',
                        light: '#F8FAFC',
                        gray_text: '#64748B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-light text-dark font-sans antialiased">

    <nav class="fixed w-full z-50 top-0 bg-white/90 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="index.php" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-car-side text-xl"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-dark">MaBagnole<span class="text-primary">.</span></span>
                </a>
                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="index.php" class="text-primary font-semibold">Catalogue</a>
                    <a href="blog.php" class="text-gray-600 hover:text-primary transition">Blog & Communauté</a>
                </div>
                <div class="flex items-center gap-4">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="hidden md:flex flex-col text-right mr-2">
                            <span class="text-sm font-bold text-dark"><?= htmlspecialchars($_SESSION['user']['nom_complet'] ?? 'Mon Compte') ?></span>
                            <span class="text-xs text-green-600 font-bold">Connecté</span>
                        </div>
                        <a href="mes-reservations.php" class="text-gray-600 hover:text-primary text-sm font-medium hidden md:block">
                            <i class="fa-solid fa-calendar-check text-lg"></i>
                        </a>
                        <a href="logout.php" class="px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-100 transition border border-red-100">
                            <i class="fa-solid fa-power-off"></i>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="hidden md:block text-sm font-medium text-gray-600 hover:text-primary transition">Connexion</a>
                        <a href="register.php" class="px-5 py-2.5 bg-dark text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition shadow-lg">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-32 pb-20 max-w-7xl mx-auto px-6 lg:px-8">
        
        <a href="index.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary mb-8 transition font-medium">
            <i class="fa-solid fa-arrow-left"></i> Retour au catalogue
        </a>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                
                <div class="h-96 lg:h-auto relative bg-gray-100">
                    <img src="<?= !empty($voiture['image_url']) ? htmlspecialchars($voiture['image_url']) : 'assets/img/default.jpg' ?>" 
                         alt="<?= htmlspecialchars($voiture['marque']) ?>" 
                         class="absolute inset-0 w-full h-full object-cover">
                    
                    <span class="absolute top-6 left-6 bg-white/90 backdrop-blur text-dark text-sm font-bold px-4 py-2 rounded-lg shadow-sm uppercase tracking-wide">
                        <?= htmlspecialchars($voiture['nom_categorie'] ?? 'Véhicule') ?>
                    </span>
                </div>

                <div class="p-8 lg:p-12 flex flex-col justify-center">
                    
                    <div class="mb-6">
                        <h1 class="text-4xl font-bold text-dark mb-2">
                            <?= htmlspecialchars($voiture['marque']) ?> 
                            <span class="text-primary"><?= htmlspecialchars($voiture['modele']) ?></span>
                        </h1>
                        <div class="flex items-center gap-2 text-green-600 font-medium bg-green-50 w-fit px-3 py-1 rounded-full text-sm">
                            <i class="fa-solid fa-check-circle"></i> Disponible immédiatement
                        </div>
                    </div>

                    <div class="mb-8 p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-600 font-semibold uppercase">Prix par jour</p>
                            <p class="text-3xl font-bold text-primary"><?= htmlspecialchars($voiture['prix_journalier']) ?> €</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-400">Assurance incluse</p>
                            <p class="text-xs text-blue-400">Kilométrage illimité</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-dark mb-3">Description</h3>
                        <p class="text-gray_text leading-relaxed">
                            <?= nl2br(htmlspecialchars($voiture['description'] ?? 'Aucune description disponible pour ce véhicule.')) ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-10">
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <i class="fa-solid fa-gas-pump text-2xl text-gray-400 mb-2"></i>
                            <p class="text-xs font-bold text-dark">Essence</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <i class="fa-solid fa-gears text-2xl text-gray-400 mb-2"></i>
                            <p class="text-xs font-bold text-dark">Automatique</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <i class="fa-solid fa-user-group text-2xl text-gray-400 mb-2"></i>
                            <p class="text-xs font-bold text-dark">5 Places</p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="reservation.php?id=<?= $voiture['id'] ?>" 
                               class="block w-full py-4 bg-primary hover:bg-primary_hover text-white text-center font-bold rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                                Réserver ce véhicule
                            </a>
                        <?php else: ?>
                            <a href="login.php" 
                               class="block w-full py-4 bg-dark hover:bg-gray-800 text-white text-center font-bold rounded-xl transition">
                                Connectez-vous pour réserver
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400 text-xs">&copy; 2024 MaBagnole SAS. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>