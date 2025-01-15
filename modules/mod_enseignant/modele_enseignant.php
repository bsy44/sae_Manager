<?php
class modele_enseignant extends connexion{ 
    
    public function idEns($login){
        $requete  = self::$bdd->prepare('select idEns from enseignant where login = ?');
        $requete->execute([$login]);
        $res = $requete->fetch();
        return $res['idEns'];
    }
    public function ajouterSAE($intitule, $dateDebut,$dateFin, $description, $lien, $semestre, $idEns, $coresponsable){
        $requete  = self::$bdd->prepare('insert into projet (intitule, DateDebut, DateFin, description, lien,semestre,idEns, coresponsable) values ( ?, ?, ?, ?, ?, ?, ?, ?)');
        return $requete->execute([$intitule, $dateDebut, $dateFin, $description, $lien, $semestre, $idEns, $coresponsable]);
    }



    public function getlisteSAEencours($login){
        $requete  = self::$bdd->prepare('SELECT DISTINCT p.* FROM projet p
                                        LEFT JOIN estCoResponsable cr ON p.idProjet = cr.idProjet
                                        LEFT JOIN estIntervenant i ON p.idProjet = i.idProjet
                                        JOIN enseignant e ON e.idEns = p.idEns 
                                            OR e.idEns = cr.idEns 
                                            OR e.idEns = i.idEns
                                        WHERE e.login = ? and p.DateDebut<=? and ?<p.DateFin');
                                        
        $requete->execute([$login, date("Ymd"),  date("Ymd")]);
        return $requete->fetchAll();
    }
    public function getlisteSAEtermine($login){
        $requete  = self::$bdd->prepare('SELECT DISTINCT p.* FROM projet p
                                        LEFT JOIN estCoResponsable cr ON p.idProjet = cr.idProjet
                                        LEFT JOIN estIntervenant i ON p.idProjet = i.idProjet
                                        JOIN enseignant e ON e.idEns = p.idEns 
                                            OR e.idEns = cr.idEns 
                                            OR e.idEns = i.idEns
                                        WHERE e.login = ? and p.DateFin<?');
                                        
        $requete->execute([$login, date("Ymd")]);
        return $requete->fetchAll();
    }
    public function getlisteSAEavenir($login){
        $requete  = self::$bdd->prepare('SELECT DISTINCT p.* FROM projet p
                                        LEFT JOIN estCoResponsable cr ON p.idProjet = cr.idProjet
                                        LEFT JOIN estIntervenant i ON p.idProjet = i.idProjet
                                        JOIN enseignant e ON e.idEns = p.idEns 
                                            OR e.idEns = cr.idEns 
                                            OR e.idEns = i.idEns
                                        WHERE e.login = ? and p.DateDebut>? ');
                                        
        $requete->execute([$login, date("Ymd")]);
        return $requete->fetchAll();
    }

    public function peutModifier($idEns, $idProjet){
        $requete  = self::$bdd->prepare('select idEns from projet where idprojet = ?');        
        $requete->execute([$idProjet]);
        $res = $requete->fetch();
        $requete2  = self::$bdd->prepare('select idEns from estCoResponsable where idprojet = ?');        
        $requete2->execute([$idProjet]);
        $res2 = $requete2->fetch();
        if ($res && $idEns == $res['idEns']  || $res2 && $idEns == $res2['idEns'] ){
            return true; 
        }
        else{
            return false;
        }
    }

    public function getRessource($idProjet){
        $requete  = self::$bdd->prepare('select * from ressource where idprojet = ?');        
        $requete->execute([$idProjet]);
        return $requete->fetchAll();
    }

    public function getDepot($idProjet){
        $requete  = self::$bdd->prepare('select * from depot where idprojet = ?');        
        $requete->execute([$idProjet]);
        return $requete->fetchAll();
    }

    public function ajoutdepot($idProjet, $nomDepot, $datepublication, $datelimite, $description){
        $requete  = self::$bdd->prepare('insert into depot (idProjet, nom, datePublication, dateLimite, description) values ( ?, ?, ?, ?, ?)');
        return $requete->execute([$idProjet, $nomDepot, $datepublication, $datelimite, $description]);
    }

    public function ajoutRessource($idProjet, $nomRessource, $lienRessource){
        $requete  = self::$bdd->prepare('insert into ressource (idProjet, nom, lien) values ( ?, ?, ?)');
        return $requete->execute([$idProjet, $nomRessource, $lienRessource]);
    }

    public function getlistenseignantNonIntervenant($idProjet){
        $requete  = self::$bdd->prepare('select * from enseignant where idEns not in (select idEns from estIntervenant where idProjet = ?) and idEns != (select idEns from projet where idProjet= ? ) and idEns != (select coresponsable from projet where  idProjet= ? )');        
        $requete->execute([$idProjet, $idProjet, $idProjet]);
        return $requete->fetchAll();
    }


    public function getlisteintervenant($idProjet){
        $requete  = self::$bdd->prepare('select * from enseignant where idEns  in (select idEns from estIntervenant where idProjet = ?)');        
        $requete->execute([$idProjet]);
        return $requete->fetchAll();
    }

    public function ajoutIntervenant($idEns, $idProjet){
        $requete  = self::$bdd->prepare('insert into estIntervenant (idEns, idProjet) values ( ?, ?)');
        return $requete->execute([$idEns, $idProjet]);
    }

    public function supprimerSae($idProjet) {
        $requete = self::$bdd->prepare(' DELETE FROM projet WHERE projet.idProjet = ? ');
        return $requete->execute([$idProjet]);
    }

    function getGroupePropose($sae){
        $requete = self::$bdd->prepare('SELECT * FROM groupeTemporaire where idProjet = ?');
        $requete->execute([$sae]);
        return $requete->fetchAll();
    }

    function detailEleve($igGrp){
        $requete = self::$bdd->prepare('SELECT * FROM etudiant JOIN groupeTemporaire on idEtu = idEtudiant where idGroupe = ?');
        $requete->execute([$igGrp]);
        return $requete->fetchAll();
    }

    function insertionFinaleGroupe($idGroupe, $idEtudiant, $idProjet){
        $req = self::$bdd->prepare('INSERT INTO groupe (idGroupe, idEtudiant, idProjet) values (?, ?, ?)');
        return $req->execute([$idGroupe, $idEtudiant, $idProjet]);
    }

    function supprimerGroupeTemporaire($idGroupe, $idEtudiant, $idProjet){
        $req = self::$bdd->prepare('DELETE FROM groupeTemporaire WHERE idGroupe = ? AND idEtudiant = ? AND idProjet = ?');
        return $req->execute([$idGroupe, $idEtudiant, $idProjet]);
    }

    function getGroupe($sae){
        $req = self::$bdd->prepare('SELECT * FROM etudiant JOIN groupe on idEtu = idEtudiant where idProjet = ?');
        $req->execute([$sae]);
        return $req->fetchAll();
    }

    public function getListeSemestre(){
        $requete  = self::$bdd->prepare('select distinct semestre from etudiant');        
        $requete->execute();
        return $requete->fetchAll();
    }
    
    public function getListeEnseignant($login){
        $requete  = self::$bdd->prepare('select * from enseignant where login!= ?');        
        $requete->execute([$login]);
        return $requete->fetchAll();
    }

    public function supprimerIntervenant($idEns, $idProjet){
        $req = self::$bdd->prepare('DELETE FROM estIntervenant WHERE idEns = ? AND idProjet = ?');
        return $req->execute([$idEns, $idProjet]);
    }
}
?>