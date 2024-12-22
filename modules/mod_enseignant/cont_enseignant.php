<?php
include_once 'modele_enseignant.php';
include_once 'vue_enseignant.php';

class Cont_enseignant{
    private $vue_enseignant;
    private $modele_enseignant;
    private $action;
    
    public function __construct(){
        $this->vue_enseignant = new vue_enseignant();    
        $this->modele_enseignant = new modele_enseignant();
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "Bienvenue";
    }


    public function afficher(){
        $this->vue_enseignant->formualire();
    }
    public function exec(){
        $this->afficher(); 
    }
    
}
?>