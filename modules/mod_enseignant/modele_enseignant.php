<?php
class modele_enseignant extends connexion{ 
    
    public function idEns($login){
        $requete  = self::$bdd->prepare('select idEns from enseignant where login = ?');
        $requete->execute([$login]);
        $res = $requete->fetch();
        return $res['idEns'];
    }
    public function ajouterSAE($intitule, $dateDebut,$dateFin, $description, $lien, $annee, $semestre, $idEns){
        $requete  = self::$bdd->prepare('insert into projet (intitule, DateDebut, DateFin, description, lien, annee,semestre,idEns) values ( ?, ?, ?, ?, ?, ?, ?, ?)');
        return $requete->execute([$intitule, $dateDebut, $dateFin, $description, $lien, $annee, $semestre, $idEns]);
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

    public function validationGroupe() {

        /*if (isset($_POST['sae']) && isset($_POST['prenom'])) {
            $sae = htmlspecialchars($_POST['sae']); // Le SAE sélectionné
            $etudiant1 = htmlspecialchars($_POST['prenom']); // Le nom de l'étudiant sélectionné

            // Affiche les valeurs récupérées
            echo "Saé sélectionné : " . $sae . "<br>";
            echo "Étudiant 1 sélectionné : " . $etudiant1 . "<br>";


            // Ajoutez d'autres traitements selon votre logique (insertion dans la base de données, etc.)
        } else {
            echo "Les données du formulaire ne sont pas envoyées correctement.";
        }*/
    }


}

?>
