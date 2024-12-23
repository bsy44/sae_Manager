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
    
}

?>
