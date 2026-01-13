<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Database;
use App\Model\Article;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: blog.php');
    exit;
}

$id = $_GET['id'];

$database = new Database();
$conn = $database->getConnection();
$article = Article::getById($conn, $id);

if (!$article) {
    header('Location: blog.php');
    exit;
}

$img = !empty($article['image_url']) ? htmlspecialchars($article['image_url']) : 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80';
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['titre']) ?> - Blog MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563EB', primary_hover: '#1D4ED8', dark: '#0F172A', light: '#F8FAFC', gray_text: '#64748B' }
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
                    <a href="index.php" class="text-gray-600 hover:text-primary transition">Catalogue</a>
                    <a href="blog.php" class="text-primary font-semibold">Blog & Communauté</a> 
                </div>
                <div class="flex items-center gap-4">
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="hidden md:flex flex-col text-right mr-2">
                            <span class="text-sm font-bold text-dark"><?= htmlspecialchars($_SESSION['user']['nom_complet'] ?? 'Mon Compte') ?></span>
                            <span class="text-xs text-green-600 font-bold">Connecté</span>
                        </div>
                        <a href="mes-reservations.php" class="text-gray-600 hover:text-primary"><i class="fa-solid fa-calendar-check text-lg"></i></a>
                        <a href="logout.php" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg"><i class="fa-solid fa-power-off"></i></a>
                    <?php else: ?>
                        <a href="login.php" class="hidden md:block text-sm font-medium text-gray-600 hover:text-primary">Connexion</a>
                        <a href="register.php" class="px-5 py-2.5 bg-dark text-white text-sm font-semibold rounded-lg hover:bg-gray-800">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-32 pb-10 bg-white border-b border-gray-100">
        <div class="max-w-3xl mx-auto px-6 text-center">
            
            <div class="flex items-center justify-center gap-2 mb-6">
                <span class="px-3 py-1 rounded-full bg-blue-50 text-primary text-xs font-bold uppercase tracking-wide">
                    <?= htmlspecialchars($article['theme']) ?>
                </span>
                <span class="text-gray-300">•</span>
                <span class="text-gray-500 text-sm font-medium">
                    <?= date('d M Y', strtotime($article['date_creation'])) ?>
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl font-bold text-dark leading-tight mb-6">
                <?= htmlspecialchars($article['titre']) ?>
            </h1>

            <div class="flex items-center justify-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm font-bold text-dark"><?= htmlspecialchars($article['auteur'] ?? 'Auteur inconnu') ?></p>
                    <p class="text-xs text-gray-500">Rédacteur MaBagnole</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 -mt-8">
        <div class="rounded-2xl overflow-hidden shadow-2xl mb-12">
            <img src="<?= $img ?>" class="w-full h-[400px] object-cover">
        </div>
        
        <div class="max-w-3xl mx-auto prose prose-lg prose-blue text-gray-700 leading-relaxed text-justify">
            <?= nl2br(htmlspecialchars($article['contenu'])) ?>
        </div>

        <div class="max-w-3xl mx-auto mt-12 pt-8 border-t border-gray-200 flex justify-between items-center">
            <div class="flex gap-2">
                <span class="text-sm font-bold text-dark">Partager :</span>
                <a href="#" class="text-gray-400 hover:text-blue-600"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="text-gray-400 hover:text-green-500"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <section class="bg-gray-50 py-16 mt-16 border-t border-gray-200">
        <div class="max-w-3xl mx-auto px-6">
            <h3 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3">
                Commentaires <span class="bg-primary text-white text-sm px-2 py-0.5 rounded-full">3</span>
            </h3>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-10">
                <textarea class="w-full bg-gray-50 border border-gray-200 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-primary/20" rows="3" placeholder="Laissez un commentaire..."></textarea>
                <div class="flex justify-end mt-3">
                    <button class="bg-dark text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 text-sm transition">Publier</button>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary font-bold flex-shrink-0">AL</div>
                    <div>
                        <div class="bg-white p-4 rounded-xl rounded-tl-none shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-dark">Amine L.</span>
                                <span class="text-xs text-gray-400">Il y a 2h</span>
                            </div>
                            <p class="text-gray-600 text-sm">Super article ! J'ai fait le même trajet l'année dernière, c'était incroyable.</p>
                        </div>
                        <button class="text-xs text-gray-500 font-medium mt-1 ml-2 hover:text-primary">Répondre</button>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold flex-shrink-0">SB</div>
                    <div>
                        <div class="bg-white p-4 rounded-xl rounded-tl-none shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-dark">Sarah B.</span>
                                <span class="text-xs text-gray-400">Hier</span>
                            </div>
                            <p class="text-gray-600 text-sm">Merci pour les conseils mécaniques, ça m'aidera pour ma prochaine location.</p>
                        </div>
                        <button class="text-xs text-gray-500 font-medium mt-1 ml-2 hover:text-primary">Répondre</button>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold flex-shrink-0">KM</div>
                    <div>
                        <div class="bg-white p-4 rounded-xl rounded-tl-none shadow-sm border border-gray-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-dark">Karim M.</span>
                                <span class="text-xs text-gray-400">2 jours</span>
                            </div>
                            <p class="text-gray-600 text-sm">Est-ce que l'Urus est disponible à Tanger aussi ou seulement à Marrakech ?</p>
                        </div>
                        <button class="text-xs text-gray-500 font-medium mt-1 ml-2 hover:text-primary">Répondre</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>