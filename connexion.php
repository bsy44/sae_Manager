<?php

Class connexion{
    
    protected static $bdd;

    public static function initconnexion(){
        $dsn = 'mysql:dbname=dutinfopw201642;host=database-etudiants.iut.univ-paris8.fr';
        $user = 'dutinfopw201642';
        $password = 'pubepete';

        self::$bdd = new PDO($dsn, $user, $password);
    }
}
?>