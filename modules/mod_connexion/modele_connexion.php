<?php
    require_once 'connexion.php';
    class Modele_connexion extends Connexion{

        public function getUtilisateur($login) {
            $req = self::$bdd->prepare("SELECT * from enseignant WHERE login=? UNION SELECT * from etudiant WHERE login=?");
            $req->execute([$login, $login]);
            return $req->fetch();
        }

        public function getmdp($id){
            $sql = 'select password from enseignant where login = ? UNION select password from etudiant where login = ? ';
            $req = self::$bdd->prepare($sql);
            $req->execute([$id, $id]);
            $mdp = $req->fetch()[0];
            echo $mdp;
        }

        public function get_passwdHash($mdp){
            return password_hash($mdp, PASSWORD_DEFAULT);
        }
    }
?>