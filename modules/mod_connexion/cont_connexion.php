<?php
    require_once "modules/mod_connexion/modele_connexion.php";
    require_once "modules/mod_connexion/vue_connexion.php";
    
    class Cont_connexion{
        private $modele;
        private $vue;
        private $action;

        public function __construct(){
            $this->modele = new Modele_connexion();
            $this->vue = new Vue_connexion();
            $this->action = isset($_GET["action"]) ? $_GET["action"] :"";
        }

        public function exec(){
            $this->vue->menu();
            switch($this->action){
                case 'connexion' :
                    $this->connexion();
                break;

                case "deconnexion" :
                    $this->deconnexion();
                break;
            }
        }

        public function connexion(){
            
            $this->vue->form_connexion();

            $login = isset ($_POST['login']) ? $_POST['login'] : exit;
            $password = isset ($_POST['password']) ? $_POST['password'] : exit;
            $util = $this->modele->getUtilisateur($login);
            
            if ($util === false) {
                $this->vue->util_inconnu();
            }

            else if ($this->modele->getmdp($_POST['login']) == $_POST['password']) {
                
                $_SESSION['login'] = $login;
                $this->vue->messageConnexionReussie();
            }
            else {
                echo $_POST['password'];
                //$this->vue->messageErreurConnexion();
            }
        }

        public function deconnexion () {
            unset($_SESSION['login']);
            $this->vue->deconnexion();
        }
    }
?>