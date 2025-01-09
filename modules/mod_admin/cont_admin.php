<?php
include_once 'modele_admin.php';
include_once 'vue_admin.php';

class Cont_admin{
    private $vue_admin;
    private $modele_admin;
    private $action;
    
    public function __construct(){
        $this->vue_admin = new vue_admin();    
        $this->modele_admin = new modele_admin();
        $this->action =  isset($_GET['action'])?  $_GET['action'] : "ajouter";
    }

    public function afficher(){
        $this->vue_admin->formualire();
    }

    public function ajoutEns() {
        $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : exit;
        $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null;
        $login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : null;
        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
        $this->modele_admin->ajouterEns($prenom, $nom, $login, $password); 
    }

    public function ajoutEtu() {
        $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : exit;
        $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : null;
        $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : null;
        $login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : null;
        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
        $this->modele_admin->ajouterEtu($prenom, $nom, $semestre, $login, $password); 
    }

    public function exec(){
        $this->afficher();
        switch($this->action){
            case 'ajoutEtu':
                $this->ajoutEtu();
                break;
            case 'ajoutEns':
                
                $this->ajoutEns();
                break;
        }
    }

}
?>