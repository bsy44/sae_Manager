<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';
//session_start();

class Cont_enseignant{
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;

    public function __construct(){
        $this->vue_enseignant = new vue_enseignant();    
        $this->modele_enseignant = new modele_enseignant();
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
       
    }

    public function acceuil(){
        $this->vue_enseignant->acceuil();
        $this->vue_enseignant->listeSAEencours( $this->modele_enseignant->getlisteSAEencours($_SESSION['login']));
       
    }

    public function exec(){
       
        switch($this->action){
            case "Bienvenue";
                $this->acceuil();
                break;
            case "btnajoutsae":
                $this->acceuil();
                $this->vue_enseignant->formulaireAjoutSAE();
                break;
            case "ajoutsae":
                $this->ajoutersae();
                break;
        }
    }

    public function getIdEns(){
        return $this->modele_enseignant->idEns($_SESSION['login']);
    }

    public function ajouterSAE(){
        $intitule = isset($_POST['intitule']) ? htmlspecialchars($_POST['intitule']) : exit;
        $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
        $lien = isset($_POST['lien']) ? htmlspecialchars($_POST['lien']) : null;
        $annee = isset($_POST['annee']) ? htmlspecialchars($_POST['annee']) : null;
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $idEns = $this->getIdEns();
        $this->acceuil();
        if ($this->modele_enseignant->ajouterSAE($intitule, $description, $lien, $annee, $semestre, $idEns)){
            echo "Erreur ";
            $this->vue_enseignant->formulaireAjoutSAE();
        }
    }
    
}
?>