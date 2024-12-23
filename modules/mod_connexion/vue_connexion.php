<?php
    class Vue_connexion{

        public function form_connexion(){
        echo '
            <form action="index.php?module=mod_connexion&action=connexion" METHOD="POST">
                login : <input type ="text" name="login" required ><br>
                Mot de passe : <input type="password" name="password" required>
                <input type="submit" value="Se connecter"/>
            </form>';
        }

        public function messageErreurConnexion(){
            echo "login ou mot de passe incorrecte";
        }

        public function deconnexion(){
            echo"Déconnecté avec succès !";
        }
    }
?>