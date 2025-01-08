<?php
class vue_etudiant{

    public function menu() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
        ';

    }
    public function afficherDepots($depots) {
        echo "<h1>Dépôts disponibles</h1>";
        echo "<ul>";
        foreach ($depots as $depot) {
            echo "<li>Dépôt ID: {$depot['idDepot']} - {$depot['description']} (Deadline: {$depot['date_limite']})</li>";
        }
        echo "</ul>";
    }

   
    public function afficherFormulaireDepot($idDepot) {
        echo "<h1>Déposer un fichier</h1>";
        echo "<form method='POST' enctype='multipart/form-data'>";
        echo "<label>ID Étudiant :</label><input type='number' name='idEtud' required><br>";
        echo "<input type='hidden' name='idDepot' value='$idDepot'>";
        echo "<label>Fichier :</label><input type='file' name='fichier' required><br>";
        echo "<button type='submit'>Déposer</button>";
        echo "</form>";
    }
}
?>


