<?php
    include_once 'connexion.php';
    require_once 'modules/mod_connexion/mod_connexion.php';

    $connexion = new Connexion();
    $connexion->initConnexion();
    

    $module = isset($_GET["module"]) ? $_GET["module"] : "mod_connexion";
    switch($module){
    case "mod_admin":
        new ModAdmin();
        break;
    case "mod_equipes":
        new ModEquipes();
        break;
    case "mod_connexion":
        new modconnexion();
    }
?>