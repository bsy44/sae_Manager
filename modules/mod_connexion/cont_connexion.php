<?php
require_once "modules/mod_connexion/modele_connexion.php";
require_once "modules/mod_connexion/vue_connexion.php";

session_start();
class Cont_connexion {
    private $modele;
    private $vue;
    private $action;

    public function __construct() {
        $this->modele = new Modele_connexion();
        $this->vue = new Vue_connexion();
        $this->action = isset($_GET["action"]) ? $_GET["action"] : "bienvenue";
       
    }

    public function exec() {
        switch ($this->action) {
            case 'bienvenue':
                $this->vue->form_connexion();
            break;
            case 'connexion':
                $this->verifConnexion();
            break;
            case "deconnexion" :
                $this->deconnexion();
            break;
        }
        if (isset($_SESSION['login'])) {
            $role = $this->modele->getRole($_SESSION['login']); // Utiliser la session pour récupérer le login
            $this->redirectionRole($role);
            exit;
        }
    }

    public function redirectionRole($role) {
        switch ($role) {
            case 'enseignant':
                header("Location: index.php?module=mod_enseignant");
                break;
            case 'etudiant':
                header("Location: index.php?module=mod_etudiant");
                break;
            case 'admin':
                header("Location: index.php?module=mod_admin");
                break;
        }
        exit;
    }
    
    

    
    public function verifConnexion() {
       
        $login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : null;
        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;

        if ( $this->modele->verifuser($login, $password)) { 
            $_SESSION['login'] = $login;

            $this->redirectionRole($this->modele->getRole($login));
            exit;
        } else {
            $this->vue->form_connexion();
            $this->vue->messageErreurConnexion();
        }
    }
    public function deconnexion() {
        // Détruire toutes les variables de session
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?module=mod_connexion&action=bienvenue');
        exit;
    }
    
}
?>
