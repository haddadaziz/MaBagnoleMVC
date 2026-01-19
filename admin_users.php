<?php
// admin_users.php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/database.php';

use App\Database;
use App\Models\User;

session_start();

$database = new Database();
$conn = $database->getConnection();

$users = User::getAll($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#2563EB', dark: '#0F172A', light: '#F8FAFC' } } }
        }
    </script>
</head>

<body class="bg-light font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-dark text-white flex flex-col shadow-2xl z-20">
        <div class="h-20 flex items-center px-8 border-b border-gray-800">
            <i class="fa-solid fa-car-side text-primary text-2xl mr-3"></i>
            <span class="text-xl font-bold tracking-tight">MaBagnole<span class="text-primary">.</span></span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="admin_dashboard.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium"><i
                    class="fa-solid fa-chart-pie w-5"></i> Vue d'ensemble</a>
            <a href="admin_vehicules.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium"><i
                    class="fa-solid fa-car w-5"></i> Véhicules</a>
            <a href="admin_reservations.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium"><i
                    class="fa-solid fa-calendar-check w-5"></i> Réservations</a>
            <a href="admin_users.php"
                class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl transition font-medium"><i
                    class="fa-solid fa-users w-5"></i> Utilisateurs</a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-comments w-5"></i>
                Avis Clients
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="text-2xl font-bold text-dark">Gestion des Utilisateurs</h2>
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500"><i
                    class="fa-solid fa-user"></i></div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4 font-semibold">Utilisateur</th>
                            <th class="p-4 font-semibold">Rôle</th>
                            <th class="p-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                            <?= strtoupper(substr($user['nom_complet'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                <?= htmlspecialchars($user['nom_complet']) ?></div>
                                            <div class="text-gray-500 text-xs"><?= htmlspecialchars($user['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold border border-purple-200">
                                            <i class="fa-solid fa-shield-halved text-[10px]"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">Client</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right">
                                    <?php if ($user['role'] !== 'admin'): ?>
                                        <form action="actions/delete_user.php" method="POST"
                                            onsubmit="return confirm('Supprimer cet utilisateur ?');" class="inline-block">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 transition text-sm font-medium">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>