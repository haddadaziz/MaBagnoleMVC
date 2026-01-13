<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

// 1. SÉCURITÉ : Si le gars n'est pas connecté, il dégage !
if (!isset($_SESSION['user'])) {
    header('Location: login.php?error=Vous devez être connecté pour écrire un article.');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rédiger un article - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563EB', dark: '#0F172A', light: '#F8FAFC' }
                }
            }
        }
    </script>
</head>

<body class="bg-light text-dark font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-100 p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="blog.php" class="text-gray-500 hover:text-primary transition font-medium flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Retour au blog
            </a>
            <span class="font-bold text-dark">Rédaction</span>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-primary px-8 py-6">
                <h1 class="text-2xl font-bold text-white">Partagez votre expérience</h1>
                <p class="text-blue-100 text-sm">Roadtrip, conseil mécanique ou essai auto ? À vous la parole.</p>
            </div>

            <form action="actions/add_article.php" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Titre de l'article</label>
                    <input type="text" name="titre" required placeholder="Ex: Mon roadtrip de 1000km en Clio 4..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 transition font-bold text-lg text-dark">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Thème</label>
                        <div class="relative">
                            <i
                                class="fa-solid fa-hashtag absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="theme"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 appearance-none">
                                <option value="Roadtrip">Roadtrip</option>
                                <option value="Mécanique">Conseil Mécanique</option>
                                <option value="Test">Test & Essai</option>
                                <option value="Nouveautés">Nouveautés</option>
                                <option value="Autre">Autre</option>
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Image de couverture</label>
                        <input type="file" name="image" accept="image/*" required
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Votre histoire</label>
                    <textarea name="contenu" rows="10" required placeholder="Racontez-nous tout..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 transition"></textarea>
                    <p class="text-xs text-gray-400 mt-2 text-right">Minimum 50 caractères.</p>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="blog.php" class="text-gray-500 hover:text-dark font-medium transition">Annuler</a>
                    <button type="submit"
                        class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                        Publier l'article <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>