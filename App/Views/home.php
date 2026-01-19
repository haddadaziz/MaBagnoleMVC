<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaBagnole - Location de Voitures</title>
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

    <nav
        class="fixed w-full z-50 top-0 bg-white/90 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="index.php" class="flex items-center gap-2 group">
                    <div
                        class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-car-side text-xl"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-dark">MaBagnole<span
                            class="text-primary">.</span></span>
                </a>

                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="index.php" class="text-primary font-semibold">Catalogue</a>
                </div>

                <div class="flex items-center gap-4">

                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="hidden md:flex flex-col text-right mr-2">
                            <span class="text-sm font-bold text-dark">
                                <?= htmlspecialchars($_SESSION['user']['nom_complet'] ?? 'Mon Compte') ?>
                            </span>
                            <span class="text-xs text-green-600 font-bold">Connecté</span>
                        </div>

                        <a href="mes-reservations.php"
                            class="text-gray-600 hover:text-primary text-sm font-medium hidden md:block"
                            title="Mes réservations">
                            <i class="fa-solid fa-calendar-check text-lg"></i>
                        </a>

                        <a href="logout.php"
                            class="px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-100 transition border border-red-100">
                            <i class="fa-solid fa-power-off"></i>
                        </a>

                    <?php else: ?>
                        <a href="login.php"
                            class="hidden md:block text-sm font-medium text-gray-600 hover:text-primary transition">Connexion</a>
                        <a href="register.php"
                            class="px-5 py-2.5 bg-dark text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition shadow-lg">
                            Inscription
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-primary text-xs font-semibold uppercase tracking-wide mb-6 border border-blue-100">
                    <span class="w-2 h-2 rounded-full bg-primary"></span> Nouvelle flotte 2024
                </div>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-dark mb-6 leading-tight">
                    Louez simplement, <br /> roulez <span class="text-primary">librement</span>.
                </h1>
                <p class="text-lg text-gray_text mb-10 leading-relaxed">
                    Accédez à plus de 500 véhicules disponibles immédiatement. Transparence totale, sans frais cachés.
                </p>

                <form action="index.php" method="GET"
                    class="bg-white p-2 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 flex flex-col md:flex-row gap-2 max-w-2xl mx-auto">
                    <div class="relative flex-1">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>"
                            placeholder="Modèle (ex: Clio, Golf...)"
                            class="w-full bg-gray-50 text-dark pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 transition placeholder-gray-400 font-medium">
                    </div>

                    <div class="relative w-full md:w-1/3">
                        <i
                            class="fa-solid fa-layer-group absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="categorie"
                            class="w-full bg-gray-50 text-dark pl-11 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 appearance-none cursor-pointer font-medium">
                            <option value="">Catégorie</option>
                            <option value="1" <?= $categorie == 1 ? 'selected' : '' ?>>Économique</option>
                            <option value="2" <?= $categorie == 2 ? 'selected' : '' ?>>SUV & Familiale</option>
                            <option value="3" <?= $categorie == 3 ? 'selected' : '' ?>>Premium</option>
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                    </div>

                    <button type="submit"
                        class="bg-primary hover:bg-primary_hover text-white font-bold px-8 py-3 rounded-xl transition duration-200 shadow-lg shadow-blue-500/30">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 opacity-40 pointer-events-none">
            <div
                class="absolute top-20 left-20 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
            </div>
            <div
                class="absolute top-20 right-20 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
            </div>
        </div>
    </div>

    <section class="max-w-7xl mx-auto px-6 py-16" id="catalogue">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 border-b border-gray-200 pb-6">
            <div>
                <h2 class="text-3xl font-bold text-dark">Véhicules disponibles</h2>
                <p class="text-gray_text mt-2">Choisissez le véhicule adapté à vos besoins.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php if (empty($vehicules)): ?>
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 text-gray-400">
                        <i class="fa-solid fa-car-tunnel text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-dark">Aucun véhicule trouvé</h3>
                    <p class="text-gray_text">Essayez d'autres critères de recherche.</p>
                </div>
            <?php else: ?>
                <?php foreach ($vehicules as $voiture): ?>
                    <div
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 group flex flex-col h-full overflow-hidden">

                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            <img src="<?= !empty($voiture['image_url']) ? htmlspecialchars($voiture['image_url']) : 'assets/img/default.jpg' ?>"
                                alt="<?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']) ?>"
                                class="w-full h-full object-cover mix-blend-multiply group-hover:scale-105 transition duration-500">

                            <span
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur text-dark text-xs font-bold px-3 py-1.5 rounded-md shadow-sm border border-gray-100 uppercase">
                                <?= htmlspecialchars($voiture['nom_categorie'] ?? 'Véhicule') ?>
                            </span>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-dark group-hover:text-primary transition">
                                        <?= htmlspecialchars($voiture['marque']) ?> <span
                                            class="font-normal"><?= htmlspecialchars($voiture['modele']) ?></span>
                                    </h3>
                                    <p class="text-xs text-gray-400 font-medium">Référence #<?= $voiture['id'] ?></p>
                                </div>
                                <div
                                    class="flex items-center gap-1 bg-green-50 px-2 py-1 rounded text-green-700 text-xs font-bold">
                                    <i class="fa-solid fa-check"></i> Dispo
                                </div>
                            </div>

                            <div class="mt-auto flex items-center justify-between gap-3">
                                <div>
                                    <span
                                        class="text-2xl font-bold text-dark"><?= htmlspecialchars($voiture['prix_journalier']) ?>€</span>
                                    <span class="text-sm text-gray-400">/jour</span>
                                </div>
                                <div class="flex gap-2">
                                    <a href="details.php?id=<?= $voiture['id'] ?>"
                                        class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-dark transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="reservation.php?id=<?= $voiture['id'] ?>"
                                        class="px-5 py-2.5 bg-primary hover:bg-primary_hover text-white text-sm font-bold rounded-lg shadow-md hover:shadow-lg transition flex items-center gap-2">
                                        Réserver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <?php if ($nombreDePages > 1): ?>
            <div class="mt-16 flex justify-center">
                <nav class="inline-flex rounded-lg shadow-sm border border-gray-200 bg-white">

                    <?php for ($i = 1; $i <= $nombreDePages; $i++): ?>

                        <?php if ($i == $pageActuelle): ?>
                            <span class="px-4 py-2 bg-primary text-white border-r border-primary">
                                <?= $i ?>
                            </span>
                        <?php else: ?>
                            <a href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>&categorie=<?= htmlspecialchars($categorie) ?>#catalogue"
                                class="px-4 py-2 text-gray-700 hover:text-primary hover:bg-gray-50 border-r border-gray-200 transition">
                                <?= $i ?>
                            </a>
                        <?php endif; ?>

                    <?php endfor; ?>

                </nav>
            </div>
        <?php endif; ?>
    </section>

    <footer class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-gray-400 text-xs">&copy; 2024 MaBagnole SAS. Tous droits réservés.</p>
        </div>
    </footer>
    <div class="notification success hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-green-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="success_notification"></div>
    <div class="notification error hidden fixed top-6 left-1/2 transform -translate-x-1/2 z-[999] bg-red-500 text-white px-10 py-4 rounded-full shadow-2xl border-4 border-white/30 text-lg font-bold text-center min-w-[350px] shadow-green-500/50"
        id="error_notification"></div>
</body>

</html>