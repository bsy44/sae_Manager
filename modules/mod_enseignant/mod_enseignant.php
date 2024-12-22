<?php
require_once 'cont_enseignant.php';

class Modenseignant {

    private $controller;

    public function __construct() {
        $this->controller = new cont_enseignant();
        $this->controller->exec();
    }

}

?>