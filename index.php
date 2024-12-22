<?php
    include_once 'connexion.php';
    require_once 'modules/mod_connexion/mod_connexion.php';
    require_once 'modules/mod_enseignant/mod_enseignant.php';
    require_once 'modules/mod_etudiant/mod_etudiant.php';
    require_once 'modules/mod_admin/mod_admin.php';
    $connexion = new Connexion();
    $connexion->initConnexion();
    

    $module = isset($_GET["module"]) ? $_GET["module"] : "mod_connexion";
    switch($module){
    case "mod_admin":
        new ModAdmin();
        break;
    case "mod_enseignant":
        new Modenseignant();
        break;
    case "mod_etudiant":
        new Modetudiant();
        break;
    case "mod_connexion":
        new modconnexion();
        break;
    }
?>