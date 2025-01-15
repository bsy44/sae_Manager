<?php
include_once 'modele_etudiant.php';
include_once 'vue_etudiant.php';

class Cont_etudiant {
    private $vue_etudiant;
    private $modele_etudiant;
    private $action;
    public static $idGroupe;
    public function __construct() {
        self::$idGroupe = 1;
        $this->vue_etudiant = new vue_etudiant();
        $this->modele_etudiant = new modele_etudiant();

        if (isset($_SESSION['login'])) {
            $etudiantInfo = $this->modele_etudiant->getSemestre($_SESSION['login']);
            if ($etudiantInfo) {
                $_SESSION['semestre'] = $etudiantInfo['semestre'];
            }
        }

        if (isset($_GET['idprojet'])) {
            $_SESSION['idProjet'] = $_GET['idprojet'];
        }
        if (isset($_GET['iddepot'])) {
            $_SESSION['idDepot'] = $_GET['iddepot'];
        }
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
    }


    public function exec(){
        switch($this->action){
            case "Bienvenue":
                $this->afficher();
                break;
            case 'envoieProp' : 
                $this->formGroupe();
                break;
            case "formpropgrp" :
                $this->vue_etudiant->formGroupe($this->modele_etudiant->getListeEtudiantParSem($_SESSION['semestre']));
                break;
            case "consultsae":
                $this->afficherDepots();
                $this->vue_etudiant->affichcheckllist($this->modele_etudiant->getCheckListe($_SESSION['login'], $_SESSION['idProjet']));
                break;
            case "consulterdepot":
                $this->deposerFichier();
                break;  
            case "ajoutcheckbox":
                if (!empty($_POST["checkboxmsg"])){
                    $this->modele_etudiant->ajoutcheckliste($_SESSION['login'],$_POST["checkboxmsg"]);
                }
                $this->vue_etudiant->affichcheckllist($this->modele_etudiant->getCheckListe($_SESSION['login'], $_SESSION['idProjet']));
                break;
        }
    }

    public function afficher(){
        $this->vue_etudiant->menu();
        $this->vue_etudiant->affichelisteSAE("En cours", $this->modele_etudiant->getlisteSAE($_SESSION['login']), "consultsae");
        $this->vue_etudiant->affichelisteSAE("En attente de propositon de groupe", $this->modele_etudiant->getListeSaeSansGroupe($_SESSION['login']), "formpropgrp");
        
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
    

    public function vueFormGroupe(){
        $semestre = $_SESSION['semestre'];
        $this->vue_etudiant->formGroupe($this->modele_etudiant->getListeEtudiantParSem($semestre));
    }

    public function formGroupe() {
        self::$idGroupe = $this->modele_etudiant->getLastIdGroupe()+1;
        $insertionReussie = true;

        for ($i = 1; $i <= 10; $i++) {
            if (isset($_POST["idEtu{$i}"])) {
                $idEtudiant = $_POST["idEtu{$i}"];
                if (!$this->modele_etudiant->insertionGrpTemporaire(self::$idGroupe, $idEtudiant, $_SESSION['idProjet'])) {
                    $insertionReussie = false;
                }
            }
        }

        if ($insertionReussie) {
            $this->afficher();
        } else {
            $this->vue_etudiant->formGroupe($this->modele_etudiant->getListeEtudiantParSem($_SESSION['semestre']));
        }
    }
}
?>