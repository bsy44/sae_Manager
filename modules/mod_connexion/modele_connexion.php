<?php
    require_once 'connexion.php';
    class Modele_connexion extends Connexion{

        public function getUtilisateur($login) {
            $req = self::$bdd->prepare("SELECT * from enseignant WHERE login=? UNION SELECT * from etudiant WHERE login=?");
            $req->execute([$login, $login]);
            return $req->fetch();
        }

        public function verifuser($login, $mdp){
            $sql = 'select password from enseignant where login = ? UNION select password from etudiant where login = ? ';
            $req = self::$bdd->prepare($sql);
            $req->execute([$login, $login]);
            $result = $req->fetch();
            if ($result && isset($result['password'])) {
                return password_verify($mdp, $result['password']);
            }
        
            // Si aucun utilisateur trouvé, retournez false
            return false;
            
        }

        public function getmdp($id){
            $sql = 'select password from enseignant where login = ? UNION select password from etudiant where login = ? ';
            $req = self::$bdd->prepare($sql);
            $req->execute([$id, $id]);
            return $req->fetch()[0];
        }

        public function get_passwdHash($mdp){
            return password_hash($mdp, PASSWORD_DEFAULT);
        }
    }
?>