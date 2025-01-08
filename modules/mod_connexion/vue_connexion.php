<?php
    class Vue_connexion{

        public function form_connexion(){
            echo '
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <form action="index.php?module=mod_connexion&action=connexion" METHOD="POST" class="form-signin w-100">
                    <h1 class="text-center my-4">Connexion</h1>
                    <div class="form-floating">
                        <input type="text" name="login" class="form-control" id="floatingInput" required>
                        <label for="floatingInput">Login</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="floatingPassword" required>
                        <label for="floatingPassword">Mot de passe</label>
                    </div>
                    <input class="btn btn-primary w-100 my-3" type="submit" value="Se connecter"/>
                </form>
            </div>
            ';
        }


        public function messageErreurConnexion(){
            echo "login ou mot de passe incorrecte";
        }
        public function deconnexion(){
            echo"Déconnecté avec succès !";
        }
    }
?>