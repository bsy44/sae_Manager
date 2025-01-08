<?php
class vue_enseignant{

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
        ';

    }
    public function afficherGroupes($groupes)
    {
        echo "<h1>Groupes proposés</h1>";
        foreach ($groupes as $groupe) {
            echo "<p>{$groupe['nom_groupe']} 
                    <form method='POST'>
                        <input type='hidden' name='groupe_id' value='{$groupe['id_groupe']}'>
                        <button type='submit'>Valider</button>
                    </form>
                  </p>";
        }
    }

    public function afficherEtudiantsSansGroupe($etudiants) {
        echo "<h1>Étudiants sans groupe</h1>";
        foreach ($etudiants as $etudiant) {
            echo "<p>{$etudiant['nom']} {$etudiant['prenom']}</p>";
        }
    }

}

?>