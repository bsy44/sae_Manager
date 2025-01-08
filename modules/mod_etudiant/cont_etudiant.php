<?php
include_once 'modele_etudiant.php';
include_once 'vue_etudiant.php';
include_once 

class Cont_etudiant {
    private $vue_etudiant;
    private $modele_etudiant;
    private $action; 

    public function __construct() {
        $this->vue_etudiant = new vue_etudiant();
        $this->modele_etudiant = new modele_etudiant();
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'lister';
    }

   
    public function exec() {
        switch ($this->action) {
            case 'lister':
                $this->afficherDepots();
                break;
            case 'deposer':
                $this->deposerFichier();
                break;
            default:
                echo "Action inconnue.";
                break;
        }
    }

    public function afficherDepots() {
        $depots = $this->modele_etudiant->getDepotsDisponibles($idProjet);
        $this->vue_etudiant->afficherDepots($depots);
    }

    public function deposerFichier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEtud = $_POST['idEtud'];
            $idDepot = $_POST['idDepot'];
            $fichier = $_FILES['fichier']['name'];
            $date_depot = date('Y-m-d');

            move_uploaded_file($_FILES['fichier']['tmp_name'], "uploads/" . $fichier);

            $this->modele_etudiant->ajouterDepot($iddepotetudiant, $idEtud, $fichier, $date_depot);
            echo "Fichier déposé avec succès !";
        } else {
            $idDepot = $_GET['idDepot'] ?? null;
            $this->vue_etudiant->afficherFormulaireDepot($idDepot);
        }
    }
}
?>
