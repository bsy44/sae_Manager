<?php
require_once 'cont_admin.php';

class ModAdmin {
    private $controller;
    public function __construct() {
        $this->controller = new cont_admin();
        $this->controller->exec();
    }
}
?>