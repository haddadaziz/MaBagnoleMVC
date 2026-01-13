<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js" defer></script> <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB', // Bleu MaBagnole
                        primary_hover: '#1D4ED8',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        
        <div class="bg-blue-600 py-6 text-center">
            <h1 class="text-2xl font-bold text-white font-['Montserrat']">Rejoignez-nous</h1>
            <p class="text-blue-100 text-sm">Créez votre compte client MaBagnole</p>
        </div>

        <div class="p-8">
            
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="actions/register_user.php">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nom Complet</label>
                    <input type="text" name="nom" required placeholder="Ex: Jean Dupont"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" required placeholder="jean@exemple.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" required placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-500/30">
                    S'inscrire
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Déjà un compte ? <a href="login.php" class="text-blue-600 font-bold hover:underline">Se connecter</a>
            </p>
            <p class="mt-2 text-center text-sm">
                <a href="index.php" class="text-gray-400 hover:text-gray-600 transition">Retour à l'accueil</a>
            </p>
        </div>
    </div>

    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
        
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-red-500/50"
        id="error_notification"></div>

</body>
</html>