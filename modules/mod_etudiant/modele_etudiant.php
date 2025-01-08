<?php
class modele_etudiant extends connexion{ 

    public function getlisteSAE($login){
        $requete  = self::$bdd->prepare('select * from projet where idProjet = (SELECT idProjet from groupe where idEtu = (select idEtu from etudiant where login = ?))');
        $requete->execute([$login]);
        return $requete->fetchAll();
    }

    public function getListeSaeSansGroupe($login){
        $requete  = self::$bdd->prepare('select * from projet where semestre = (select semestre from etudiant where login = ?) and idprojet not in (SELECT idProjet from groupe where idEtu = (select idEtu from etudiant where login = ?))');
        $requete->execute([$login, $login]);
        return $requete->fetchAll();
    }

}

?>
