<?php
class Vue_connexion{

    public function form_connexion($erreurco = false) {
        echo '
    <div id="connexion-container" class="container d-flex justify-content-center align-items-center vh-100">
        <form id="connexion-form" action="index.php?module=mod_connexion&action=connexion" method="POST" class="form-signin bg-light p-4 rounded shadow">
            <h1 id="connexion-title" class="text-center mb-4 text-primary">Connexion</h1>
            
            <div id="connexion-login-group" class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input id="login-input" type="text" name="login" class="form-control" placeholder="Login" required>
            </div>
    
            <div id="connexion-password-group" class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password-input" type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>';

        // Affichez le message d'erreur uniquement si $erreurco est vrai
        if ($erreurco) {
            echo '
                <div id="error-message" class="alert alert-danger mt-3">';
            $this->messageErreurConnexion();
            echo '</div>';
        }

        echo '
            <button id="connexion-button" class="btn btn-primary w-100" type="submit">Se connecter</button>
        </form>
    </div>';
    }

    public function messageErreurConnexion(){
        echo "Login ou Mot de passe incorrecte";
    }

    public function deconnexion(){
        echo"Déconnecté avec succès !";
    }
}
?>
