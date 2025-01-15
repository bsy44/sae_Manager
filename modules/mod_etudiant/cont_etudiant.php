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


    public function exec() {
        switch($this->action) {
            case "Bienvenue":
                $this->afficher();
                break;
            case "envoieProp":
                $this->formGroupe();
                break;
            case "formpropgrp":
                $this->vue_etudiant->formGroupe($this->modele_etudiant->getListeEtudiantParSem($_SESSION['semestre']));
                break;
            case "consultsae":
                $this->afficherDepots();
                $this->vue_etudiant->affichcheckllist($this->modele_etudiant->getCheckListe($_SESSION['login'], $_SESSION['idProjet']));
                break;
            case "deposerFichier": 
                $this->deposerFichier();
                break;
        
            case "ajoutcheckbox":
                if (!empty($_POST["checkboxmsg"])) {
                    $this->modele_etudiant->ajoutcheckliste($_SESSION['login'], $_POST["checkboxmsg"]);
                }
                $this->vue_etudiant->affichcheckllist($this->modele_etudiant->getCheckListe($_SESSION['login'], $_SESSION['idProjet']));
                break;
            case "consulterdepot":
               $this->deposerFichier();
                break;
            case "deposer":
                $this->deposerFichier();
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
        $idDepot = $_GET['iddepot'] ?? null; // Récupération de l'idDepot depuis la requête GET
        $this->vue_etudiant->afficherFormulaireDepot($idDepot); // Afficher le formulaire
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Vérification si la requête est POST
            $idEtud = $_SESSION['login'] ?? null; // L'ID de l'étudiant connecté
            $idDepot = $_POST['iddepot'] ?? null; // Récupération de l'ID du dépôt depuis le formulaire
    
            // Vérifie si un fichier a été soumis
            if (isset($_FILES['fichierssss']) && $_FILES['fichierssss']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['fichierssss']['tmp_name']; // Chemin temporaire du fichier
    
                // Enregistrer le chemin temporaire dans la base de données
                $date_depot = date('Y-m-d'); // Date actuelle pour l'enregistrement
                if ($idEtud && $idDepot) {
                    if ($this->modele_etudiant->ajouterDepot($idDepot, $idEtud, $fileTmpPath, $date_depot)) {
                        echo "<p style='color: green;'>Le chemin temporaire du fichier a été enregistré dans la base de données avec succès !</p>";
                    } else {
                        echo "<p style='color: red;'>Erreur lors de l'enregistrement dans la base de données.</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Erreur : Informations manquantes (ID étudiant ou ID dépôt).</p>";
                }
            } else {
                echo "<p style='color: red;'>Aucun fichier n'a été déposé ou une erreur est survenue.</p>";
            }
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