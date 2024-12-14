<?php
class modele_admin extends connexion{ 
    

    public function ajouterEns($prenom, $nom, $username, $pwd) {
        
        $requete = "INSERT INTO enseignant (prenom, nom, login, password) VALUES (?, ?, ? , ?)";
        $req = self::$bdd->prepare($requete);
        $mdp_hash = password_hash($pwd, PASSWORD_DEFAULT);
        return $req->execute([$prenom, $nom, $username, $mdp_hash]);
    }

    public function ajouterEtu($prenom, $nom, $username, $pwd) {
        
        $requete = "INSERT INTO etudiant (prenom, nom, login, password) VALUES (?, ?, ? , ?)";
        $req = self::$bdd->prepare($requete);
        $mdp_hash = password_hash($pwd, PASSWORD_DEFAULT);
        return $req->execute([$prenom, $nom, $username, $mdp_hash]);
    }

}

?>
