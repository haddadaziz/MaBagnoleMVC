<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
// verif role admin
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MaBagnole</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="script.js?v=<?= time(); ?>" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#2563EB',
                        dark: '#0F172A',
                        light: '#F8FAFC',
                        gray_text: '#64748B'
                    }
                }
            }
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
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl transition font-medium">
                <i class="fa-solid fa-chart-pie w-5"></i>
                Vue d'ensemble
            </a>

            <a href="admin_vehicules.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-car w-5"></i>
                Véhicules
            </a>
            <a href="admin_reservations.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-calendar-check w-5"></i>
                Réservations
            </a>
            <a href="admin_users.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-users w-5"></i>
                Utilisateurs
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-comments w-5"></i>
                Avis Clients
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <a href="logout.php"
                class="flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-medium">
                <i class="fa-solid fa-right-from-bracket w-5"></i>
                Déconnexion
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">

        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="text-2xl font-bold text-dark">Tableau de bord</h2>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-dark">Admin User</p>
                        <p class="text-xs text-gray-400">Super Administrateur</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray_text font-medium mb-1">Total Utilisateurs</p>
                        <h3 class="text-3xl font-bold text-dark">1,250</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 text-primary rounded-xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray_text font-medium mb-1">Véhicules</p>
                        <h3 class="text-3xl font-bold text-dark">45</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-car"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray_text font-medium mb-1">Réservations (Mois)</p>
                        <h3 class="text-3xl font-bold text-dark">128</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray_text font-medium mb-1">Revenus (Total)</p>
                        <h3 class="text-3xl font-bold text-dark">12k €</h3>
                    </div>
                    <div
                        class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-euro-sign"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-dark">Réservations Récentes</h3>
                    <button class="text-sm text-primary font-bold hover:underline">Tout voir</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray_text text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold">Client</th>
                                <th class="p-4 font-semibold">Véhicule</th>
                                <th class="p-4 font-semibold">Dates</th>
                                <th class="p-4 font-semibold">Montant</th>
                                <th class="p-4 font-semibold">Statut</th>
                                <th class="p-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">

                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-dark">Jean Dupont</td>
                                <td class="p-4 text-gray-600">Audi RS5</td>
                                <td class="p-4 text-gray-600">12/01 - 15/01</td>
                                <td class="p-4 font-bold text-dark">360€</td>
                                <td class="p-4">
                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">En
                                        attente</span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <button class="text-green-600 hover:bg-green-50 p-2 rounded transition"
                                        title="Valider"><i class="fa-solid fa-check"></i></button>
                                    <button class="text-red-500 hover:bg-red-50 p-2 rounded transition"
                                        title="Refuser"><i class="fa-solid fa-xmark"></i></button>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-dark">Sophie Martin</td>
                                <td class="p-4 text-gray-600">Fiat 500</td>
                                <td class="p-4 text-gray-600">10/01 - 11/01</td>
                                <td class="p-4 font-bold text-dark">45€</td>
                                <td class="p-4">
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Confirmée</span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <button class="text-gray-400 hover:bg-gray-100 p-2 rounded transition"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>