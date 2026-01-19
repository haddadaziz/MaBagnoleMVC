<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/classes/database.php';

session_start();

use App\Database;
use App\Models\Vehicule;
use App\Models\Categorie;

$database = new Database();
$conn = $database->getConnection();

$vehicules = Vehicule::getAll($conn);
$categories = Categorie::getAll($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Véhicules - MaBagnole</title>

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
            <a href="admin_dashboard.php"
                class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition font-medium">
                <i class="fa-solid fa-chart-pie w-5"></i>
                Vue d'ensemble
            </a>

            <a href="admin_vehicules.php"
                class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl transition font-medium">
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

    <main class="flex-1 flex flex-col overflow-y-auto relative">

        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="text-2xl font-bold text-dark">Gestion de la Flotte</h2>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-dark">Admin User</p>
                    <p class="text-xs text-gray-400">Super Administrateur</p>
                </div>
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </header>

        <div class="p-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-dark hover:bg-gray-50 active:bg-primary active:text-white transition">Tout</button>
                </div>

                <button onclick="toggleModal('addVehicleModal')"
                    class="bg-primary hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter un véhicule
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <?php if (empty($vehicules)): ?>
                    <div class="col-span-full text-center py-10 text-gray-500">
                        <i class="fa-solid fa-car-tunnel text-4xl mb-3"></i>
                        <p>Aucun véhicule dans la flotte pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($vehicules as $v): ?>
                        <div
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="<?= htmlspecialchars($v['image_url']) ?>" alt="<?= htmlspecialchars($v['marque']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                                <span
                                    class="absolute top-3 left-3 bg-dark/80 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                                    <?= htmlspecialchars($v['nom_categorie'] ?? 'Autre') ?>
                                </span>

                                <?php if ($v['disponible']): ?>
                                    <span
                                        class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">Dispo</span>
                                <?php else: ?>
                                    <span
                                        class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">Indispo</span>
                                <?php endif; ?>
                            </div>

                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-bold text-lg text-dark"><?= htmlspecialchars($v['marque']) ?>
                                            <?= htmlspecialchars($v['modele']) ?>
                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="block text-lg font-bold text-primary"><?= htmlspecialchars($v['prix_journalier']) ?>€</span>
                                        <span class="text-xs text-gray-400">/jour</span>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 my-4"></div>
                                <div class="flex justify-between items-center">
                                    <button onclick="openEditModal(this)" data-id="<?= $v['id'] ?>"
                                        data-marque="<?= htmlspecialchars($v['marque']) ?>"
                                        data-modele="<?= htmlspecialchars($v['modele']) ?>"
                                        data-prix="<?= $v['prix_journalier'] ?>" data-categorie="<?= $v['categorie_id'] ?>"
                                        class="text-gray-400 hover:text-primary transition text-sm font-medium">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Modifier
                                    </button>
                                    <form action="actions/delete_vehicule.php" method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule définitivement ?');">

                                        <input type="hidden" name="id" value="<?= $v['id'] ?>">

                                        <button type="submit"
                                            class="text-gray-400 hover:text-red-500 transition text-sm font-medium">
                                            <i class="fa-solid fa-trash mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <div id="addVehicleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">

        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity"
            onclick="toggleModal('addVehicleModal')"></div>

        <div class="bg-white rounded-2xl shadow-xl z-10 w-full max-w-lg mx-4 overflow-hidden relative">

            <form action="actions/add_vehicule.php" method="POST" enctype="multipart/form-data">
                <div class="bg-white px-6 py-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Ajouter un Véhicule</h3>
                        <button type="button" onclick="toggleModal('addVehicleModal')"
                            class="text-gray-400 hover:text-gray-600 transition">
                            <i class="fa-solid fa-xmark text-2xl"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                            <input type="text" name="marque" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50"
                                placeholder="Ex: Audi">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                            <input type="text" name="modele" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50"
                                placeholder="Ex: A3">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix / Jour (€)</label>
                            <input type="number" name="prix" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50"
                                placeholder="0.00">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="categorie_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 bg-white">
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" title="<?= htmlspecialchars($cat['description']) ?>">
                                        <?= htmlspecialchars($cat['nom']) ?>
                                    </option> <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                            <input type="file" name="image" required accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="submit"
                        class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-primary text-base font-medium text-white hover:bg-blue-700 focus:outline-none transition">Enregistrer</button>
                    <button type="button" onclick="toggleModal('addVehicleModal')"
                        class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none transition">Annuler</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editVehicleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity"
            onclick="toggleModal('editVehicleModal')"></div>

        <div class="bg-white rounded-2xl shadow-xl z-10 w-full max-w-lg mx-4 overflow-hidden relative">
            <form action="actions/update_vehicule.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" id="edit_id">

                <div class="bg-white px-6 py-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Modifier le Véhicule</h3>
                        <button type="button" onclick="toggleModal('editVehicleModal')"
                            class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark text-2xl"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marque</label>
                            <input type="text" name="marque" id="edit_marque" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                            <input type="text" name="modele" id="edit_modele" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix / Jour (€)</label>
                            <input type="number" name="prix" id="edit_prix" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="categorie_id" id="edit_categorie"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-primary/50">
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle Photo
                                (Optionnel)</label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            <p class="text-xs text-gray-400 mt-1">Laissez vide pour conserver l'image actuelle.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="submit"
                        class="rounded-xl px-6 py-2 bg-primary text-white font-medium hover:bg-blue-700 transition">Mettre
                        à jour</button>
                    <button type="button" onclick="toggleModal('editVehicleModal')"
                        class="rounded-xl px-6 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition">Annuler</button>
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