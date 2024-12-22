<?php
    require_once 'connexion.php';
    class Modele_connexion extends Connexion{


        public function verifuser($login, $mdp) {
            $sql = 'SELECT password FROM user WHERE login = ?';
            $req = self::$bdd->prepare($sql);
            $req->execute([$login]);
            $result = $req->fetch();
            
            // Vérifiez si un utilisateur est trouvé et si le hachage correspond
            if ($result && isset($result['password'])) {
        
                return password_verify($mdp, $result['password']);
            }
        
            return false;
        }
        

        public function getRole($login){
            $sql = 'select role from user where login = ?';
            $req = self::$bdd->prepare($sql);
            $req->execute([$login]);
            $result = $req->fetch();
            if ($result && isset($result['role'])) {
                return $result['role'];
            }
        }

    }
?>