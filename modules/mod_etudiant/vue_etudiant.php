<?php
class vue_etudiant{

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
        ';

    }
    public function afficherDepots($depots) {
        echo "<h1>Espaces de dépôt actifs</h1>";
        foreach ($depots as $depot) {
            echo "<p><strong>{$depot['nom']}</strong> - {$depot['description']}<br>
                  Date limite : {$depot['date_limite']} à {$depot['heure_limite']}<br>
                  <form method='POST' enctype='multipart/form-data'>
                      <input type='hidden' name='depot_id' value='{$depot['id_depot']}'>
                      <label>Fichier :</label>
                      <input type='file' name='fichier' required><br>
                      <button type='submit'>Déposer</button>
                  </form></p>";
        }
    }
    
}

?>