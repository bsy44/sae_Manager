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
        if (isset($_GET['idprojet'])) {
            $_SESSION['idProjet'] = $_GET['idprojet'];
        }
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
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
    public function afficher(){
        $this->vue_etudiant->menu();
        $this->vue_etudiant->affichelisteSAE("En cours", $this->modele_etudiant->getlisteSAE($_SESSION['login']));
        $this->vue_etudiant->affichelisteSAE("En attente de propositon de groupe", $this->modele_etudiant->getListeSaeSansGroupe($_SESSION['login']));
        
    }
    public function exec(){
        
        switch($this->action){
            case "Bienvenue":
                $this->afficher();
                break;
            case "consultsae":
                echo  $_SESSION['idProjet'];
                break;
                 case 'lister':
                $this->afficherDepots();
                break;
            case 'deposer':
                $this->deposerFichier();
                break;
            default:
                echo "Action inconnue";
                break;
        }
         
    
    }
}
?>
