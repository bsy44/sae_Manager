<?php
class vue_etudiant{

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
        ';

    }
    
}

?>