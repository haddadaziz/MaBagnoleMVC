<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/database.php';

use App\Database;
use App\Models\Reservation;

session_start();

$database = new Database();
$conn = $database->getConnection();

$reservations = Reservation::getAll($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations - Admin</title>
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
                class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl transition font-medium"><i
                    class="fa-solid fa-calendar-check w-5"></i> Réservations</a>
            <a href="admin_users.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium"><i
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
            <h2 class="text-2xl font-bold text-dark">Gestion des Réservations</h2>
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500"><i
                    class="fa-solid fa-user"></i></div>
        </header>

        <div class="p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 font-semibold">#ID</th>
                                <th class="p-4 font-semibold">Client</th>
                                <th class="p-4 font-semibold">Véhicule</th>
                                <th class="p-4 font-semibold">Dates</th>
                                <th class="p-4 font-semibold">Total</th>
                                <th class="p-4 font-semibold">Statut</th>
                                <th class="p-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach ($reservations as $res): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium text-gray-900">#<?= $res['id'] ?></td>
                                    <td class="p-4">
                                        <div class="font-medium text-gray-900"><?= $res['client_nom'] ?></div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-gray-900"><?= $res['vehicule'] ?></div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-gray-900"><i class="fa-regular fa-calendar mr-1 text-gray-400"></i>
                                            <?= $res['date_debut'] ?></div>
                                        <div class="text-gray-900"><i
                                                class="fa-solid fa-arrow-right-long mr-1 text-gray-400"></i>
                                            <?= $res['date_fin'] ?></div>
                                    </td>
                                    <td class="p-4 font-bold text-primary"><?= $res['prix_total'] ?>€</td>
                                    <td class="p-4">
                                        <?php if ($res['statut'] == 'confirmee'): ?>
                                            <span
                                                class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">Confirmée</span>
                                        <?php elseif ($res['statut'] == 'annulee'): ?>
                                            <span
                                                class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">Annulée</span>
                                        <?php else: ?>
                                            <span
                                                class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200">En
                                                attente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <?php if ($res['statut'] == 'en_attente'): ?>
                                            <button
                                                class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 transition"
                                                title="Valider">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button
                                                class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition"
                                                title="Refuser">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="text-gray-300 text-xs italic">Traité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>