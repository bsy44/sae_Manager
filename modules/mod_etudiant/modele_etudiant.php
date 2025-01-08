<?php
class Modele_etudiant extends connexion{

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
    
}
?>
