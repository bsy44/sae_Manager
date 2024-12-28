<?php
class modele_enseignant extends connexion{ 
    
    public function idEns($login){
        $requete  = self::$bdd->prepare('select idEns from enseignant where login = ?');
        $requete->execute([$login]);
        $res = $requete->fetch();
        return $res['idEns'];
    }
    public function ajouterSAE($intitule, $description, $lien, $annee, $semestre, $idEns){
        $requete  = self::$bdd->prepare('insert into projet (intitule, description, lien, annee,semestre,idEns) values ( ?, ?, ?, ?, ?, ?)');
        return $requete->execute([$intitule, $description, $lien, $annee, $semestre, $idEns]);
    }

    
    public function getlisteSAEencours($login){
        $requete  = self::$bdd->prepare('SELECT DISTINCT p.* FROM projet p
                                        LEFT JOIN estCoResponsable cr ON p.idProjet = cr.idProjet
                                        LEFT JOIN estIntervenant i ON p.idProjet = i.idProjet
                                        JOIN enseignant e ON e.idEns = p.idEns 
                                            OR e.idEns = cr.idEns 
                                            OR e.idEns = i.idEns
                                        WHERE e.login = ?');
                                        
        $requete->execute([$login]);
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
        };
    }

    public function getRessource($idProjet){
        $requete  = self::$bdd->prepare('select * from ressource where idprojet = ?');        
        $requete->execute([$idProjet]);
        return $requete->fetchAll();
    }

    public function getDepot($idProjet){
        $requete  = self::$bdd->prepare('select * from Depot where idprojet = ?');        
        $requete->execute([$idProjet]);
        return $requete->fetchAll();
    }
    
}

?>
