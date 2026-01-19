<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\Models\User;

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = User::verifier_login($conn, $email, $password);

    if ($user != null) {
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'nom_complet' => $user->getNomComplet(),
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];
        if ($user->getRole() === 'admin') {
            header("Location: admin_dashboard.php?status=success_login");
        } else {
            header("Location: index.php?status=success_login");
        }
        exit();

    } else {
        header("Location: login.php?status=login_failed");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion - MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="script.js?v=<?= time(); ?>" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-primary py-6 text-center">
            <h1 class="text-2xl font-bold text-white font-['Montserrat']">Espace Membre</h1>
            <p class="text-blue-100 text-sm">Connectez-vous à votre Espace MaBagnole</p>
        </div>

        <div class="p-8">
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" required placeholder="exemple@email.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                    <a href="#" class="text-xs text-gray-500 hover:text-primary float-right mt-1">Mot de passe oublié ?</a>
                </div>

                <button type="submit"
                    class="w-full bg-primary text-white font-bold py-3 rounded hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-500/30">
                    Se connecter
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Pas encore de compte ? <a href="register.php" class="text-primary font-bold hover:underline">S'inscrire</a>
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