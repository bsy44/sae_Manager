<?php
class modele_etudiant extends connexion{ 

    public function getListeetudiant(){
        $requete  = self::$bdd->prepare('select * from etudiant');
        $requete->execute();
        $res = $requete->fetchAll();
        return $res;
    }
   
    public function getDepotsDisponibles($idProjet) {
        $stmt = self::$bdd->prepare("SELECT * FROM depot WHERE idProjet = ?");
        $stmt->execute([$idProjet]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertionGrpTemporaire($idEtudiant, $idProjet) {
        $req = self::$bdd->prepare('INSERT INTO groupeTemporaire (idEudiant, idProjet) values (?, ?)');
        return $req->execute([$idEtudiant, $idProjet]);
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

    public function ajouterDepot($iddepotetudiant, $idEtud, $fichier, $date_depot) {
        $stmt = self::$bdd->prepare("INSERT INTO DepotEtudiants (iddepotetudiant, idEtud, fichier, date_depot) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$iddepotetudiant, $idEtud, $fichier, $date_depot]);
    }

}
?>
