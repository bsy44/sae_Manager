<?php
class modele_admin extends connexion{ 

    public function ajouterEns($prenom, $nom, $username, $pwd) {
        $requete = "INSERT INTO enseignant (login, prenom, nom) VALUES (?, ?, ?)";
        $req = self::$bdd->prepare($requete);
        if ($req->execute([$username, $prenom, $nom])){
            $mdp_hash = password_hash($pwd, PASSWORD_DEFAULT);
            $requete  = "INSERT INTO user (login, password, role) VALUES (?, ?, ?)";
            $req =  self::$bdd->prepare($requete);
            $req->execute([$username, $mdp_hash, "enseignant"]);
        }
    }

    public function ajouterEtu($prenom, $nom, $semestre, $username, $pwd) {
        $requete = "INSERT INTO etudiant (login, prenom, nom, semestre) VALUES (?, ?, ?, ? )";
        $req = self::$bdd->prepare($requete);
        $mdp_hash = password_hash($pwd, PASSWORD_DEFAULT);
        if ($req->execute([$username, $prenom, $nom, $semestre])){
            $sql  = "INSERT INTO user (login, password, role) VALUES (?, ?, ?)";
            (self::$bdd->prepare($sql))->execute([$username, $mdp_hash, "etudiant"]);
         }
    }
}
?>