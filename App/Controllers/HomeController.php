<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\Vehicule;

class HomeController {

    public function index() {
        $database = new Database(); 
        $conn = $database->getConnection();

        $search = $_GET['search'] ?? null;
        $categorie = $_GET['categorie'] ?? null;

        $toutesLesVoitures = Vehicule::getAll($conn, $search, $categorie);

        $parPage = 3;
        $totalVoitures = count($toutesLesVoitures);
        $nombreDePages = ceil($totalVoitures / $parPage);

        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $pageActuelle = (int) $_GET['page'];
        } else {
            $pageActuelle = 1;
        }

        if ($pageActuelle > $nombreDePages || $pageActuelle < 1) {
            $pageActuelle = 1;
        }

        $indexDepart = ($pageActuelle - 1) * $parPage;

        $vehicules = array_slice($toutesLesVoitures, $indexDepart, $parPage);
        
        require_once __DIR__ . '/../Views/home.php';
    }
}