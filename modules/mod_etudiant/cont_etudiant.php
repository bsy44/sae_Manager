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
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
    }

    public function afficher(){
        $this->vue_etudiant->vueGroupe($this->modele_etudiant->getPrenomEtudiant());
        $this->vue_etudiant->formualire();
    }
    public function exec(){
        $this->afficher();
    }
}
?>