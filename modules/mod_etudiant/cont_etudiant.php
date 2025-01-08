<?php
include_once 'modele_etudiant.php';
include_once 'vue_etudiant.php';


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
        if (isset($_GET['iddepot'])) {
            $_SESSION['idDepot'] = $_GET['iddepot'];
        }
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
    }

   


    public function afficherDepots() {
        $depots = $this->modele_etudiant->getDepotsDisponibles($_SESSION['idProjet']);
        $this->vue_etudiant->afficherDepots($depots);
    }

    public function deposerFichier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEtud = $_SESSION['idEtud'] ?? null; 
            $idDepot = $_POST['idDepot'] ?? null; 
            $fichier = $_FILES['fichier']['name'] ?? null;
    
            $cheminUpload = "uploads/" . basename($fichier);

          
            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $cheminUpload)) {
                $date_depot = date('d-m-Y'); 
                $this->modele_etudiant->ajouterDepot($idDepot, $idEtud, $fichier, $date_depot);
                echo "Fichier déposé avec succès !";
            } 
        } else {
            $idDepot = $_GET['idDepot'] ?? null;
            $this->vue_etudiant->afficherFormulaireDepot($idDepot);
        }
    
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
                $this->afficherDepots();
                break;
            case "consulterdepot":
                $this->deposerFichier();
                break;  
            default:
                echo "Action inconnue";
                break;
        }
         
    
    }
}
?>