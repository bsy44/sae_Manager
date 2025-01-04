<?php
class Modele_etudiant extends connexion{

    public function getPrenomEtudiant(){
        $requete  = self::$bdd->prepare('select prenom from etudiant');
        $requete->execute();
        $res = $requete->fetchAll(PDO::FETCH_COLUMN);
        return $res;
    }
}
?>
