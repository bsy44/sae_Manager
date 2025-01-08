<?php
class modele_etudiant extends connexion{ 
    public function getPrenomEtudiant(){
        $requete  = self::$bdd->prepare('select * from etudiant');
        $requete->execute();
        $res = $requete->fetchAll();
        return $res;
    }

    public function insertionGrpTemporaire($idEtudiant, $idProjet) {
        $req = self::$bdd->prepare('INSERT INTO groupeTemporaire (idEudiant, idProjet) values (?, ?)');
        $req->execute([$idEtudiant, $idProjet]);
    }
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
