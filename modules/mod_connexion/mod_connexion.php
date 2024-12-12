<?php
require_once 'cont_connexion.php';

class modconnexion{

    private $controleur;
    public function __construct() {
        $this->controleur = new Cont_connexion();
        $this->controleur->exec();
    }
}
?>