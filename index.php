<?php
    include_once 'connexion.php';
    require_once 'modules/mod_connexion/mod_connexion.php';

    session_start();

    $connexion = new Connexion();
    $connexion->initConnexion();
    new modconnexion();
?>