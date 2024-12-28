<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';

class Cont_enseignant{
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;
    private $idProjet;
    public function __construct(){
        $this->vue_enseignant = new vue_enseignant();    
        $this->modele_enseignant = new modele_enseignant();
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
        
        if (isset($_GET['idprojet'])) {
            $_SESSION['idProjet'] = $_GET['idprojet'];
        }
    
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
            case "consultsae":
                $this->afficheSAE();
                break;
            case "btnajoutdepot":
                $this->vue_enseignant->formulaireAjoutdepot();
                break;
            case "btnajoutressource":
                $this->vue_enseignant->formulaireAjoutresource();
                break;
            case "ajoutressource":
                $this->afficheSAE();
                break;
            case "ajoutressource":
                $this->afficheSAE();
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
        if ($this->modele_enseignant->ajouterSAE($intitule, $description, $lien, $annee, $semestre, $idEns)){
            $this->acceuil();
        }
        else{
            $this->vue_enseignant->formulaireAjoutSAE();
        }
    }
    
    public function afficheSAE(){
        if ($this->modele_enseignant->peutModifier($this->getIdEns(), $_SESSION['idProjet'])){
            $this->vue_enseignant->outilsAjout();
        }
        $this->vue_enseignant->listeressource($this->modele_enseignant-> getRessource($_SESSION['idProjet']));
        //Ne marche pas car le strcture de la table n'est pas bon 
        //$this->vue_enseignant->listeDepot($this->modele_enseignant-> getDepot($_SESSION['idProjet']));
    }
    
}
?>