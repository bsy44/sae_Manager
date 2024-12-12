<?php
    class Vue_connexion{

        public function menu(){
            echo'<a href="index.php?module=mod_connexion&action=connexion">Se connecter</a></br>';
        }

        public function form_connexion(){
            echo '
            <form action="index.php?module=mod_connexion&action=connexion" METHOD="POST">
                login : <input type ="text" name="login" ></input><br>
                Mot de passe : <input type="password" name="password"></input>
                <input type="submit" value="Se connecter"/>
            </form>';
        }

        public function messageConnexionReussie(){
            echo "Connexion établie avec succès !";
        }

        public function messageErreurConnexion(){
            echo "Echec de la connexion";
        }

        public function deja_connecte(){
            echo"Vous êtes déjà connecté";
        }

        public function util_inconnu(){
            echo"Utilisateur inconnu";
        }

        public function deconnexion(){
            echo"Déconnecté avec succès !";
        }
    }
?>