<?php
class vue_enseignant{

    public function acceuil() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
            </form>
            <form action="index.php?module=mod_enseignant&action=btnajoutsae" method="POST">
            <input type="submit" value="Ajout Saé">
            </form>
        ';
    }
    
    public function formulaireAjoutSAE(){
        echo '
             <form action="index.php?module=mod_enseignant&action=ajoutsae" method="POST">
                <h3>SAE</h3>
                <table>
                    <tr>
                        <td>Intitule :</td><td><input type="text" name="intitule" required></td>
                        <td>Description :</td><td><input type="text" name="description" required></td>
                        <td>Lien :</td><td><input type="text" name="lien" required></td>
                        <td>annee :</td><td><input type="text" name="annee" required></td>
                        <td>Semestre :</td><td><input type="text" name="semestre" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
        ';
    }
    
    public function listeSAEencours($liste) {
        if (empty($liste)) {
            echo "<p>Aucun projet SAE en cours </p>";
            return;
        }
    
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID Projet</th>";
        echo "<th>Intitulé</th>";
        echo "<th>Description</th>";
        echo "<th>Lien</th>";
        echo "<th>Année</th>";
        echo "<th>Semestre</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
    
        foreach ($liste as $projet) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($projet['idProjet']) . "</td>";
            echo "<td>" . htmlspecialchars($projet['intitule']) . "</td>";
            echo "<td>" . htmlspecialchars($projet['description']) . "</td>";
            echo "<td><a href='" . htmlspecialchars($projet['lien']) . "' target='_blank'>Voir le projet</a></td>";
            echo "<td>" . htmlspecialchars($projet['annee']) . "</td>";
            echo "<td>" . htmlspecialchars($projet['semestre']) . "</td>";
            echo "</tr>";
        }
    
        echo "</tbody>";
        echo "</table>";
    }
    
}

?>