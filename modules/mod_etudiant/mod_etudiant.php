<?php
require_once 'cont_etudiant.php';

class Modetudiant {

    private $controller;

    public function __construct() {
        $this->controller = new Cont_etudiant();
        $this->controller->exec();
    }

}

?>