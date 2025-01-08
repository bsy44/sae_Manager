<?php
include_once 'modele_etudiant.php';
include_once 'vue_etudiant.php';

class Cont_etudiant{
    private $vue_etudiant;
    private $modele_etudiant;
    private $action;

    public function __construct(){
        $this->vue_etudiant = new vue_etudiant();
        $this->modele_etudiant = new modele_etudiant();
        if (isset($_GET['idprojet'])) {
            $_SESSION['idProjet'] = $_GET['idprojet'];
        }
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
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
                case 'formGroupe' : 
                    $this->formGroupe();
                    break;
        }
    }

    public function formGroupe(){
        $this->vue_etudiant->formGroupe($this->modele_etudiant->getPrenomEtudiant());
        
        for ($i = 1; $i < 4; $i++) {
            if (isset($_POST["idEtu{$i}"])) {
                $idEtudiant = isset($_POST["idEtu{$i}"]) ? $_POST["idEtu{$i}"] : exit; 
                $this->modele_etudiant->insertionGrpTemporaire($idEtudiant, 1);
            }
        }
    }
    
}
?>