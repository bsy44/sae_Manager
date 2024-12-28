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
        echo '<h3> Liste SAE </h3>';
        echo "<table>";
        foreach ($liste as $projet) {
            echo '<td><a href=index.php?module=mod_enseignant&action=consultsae&idprojet=' . htmlspecialchars($projet['idProjet']) . '>' . htmlspecialchars($projet['intitule']) . '</a></td>';
        }
        echo "</table>";
    }

    public function outilsAjout(){
        echo '
        <form action="index.php?module=mod_enseignant&action=btnajoutressource" method="POST">
            <input type="submit" value="Ajouter Ressource">
        </form>
        <form action="index.php?module=mod_enseignant&action=btnajoutdepot" method="POST">
            <input type="submit" value="Ajouter Depot">
        </form>
        ';
    }

    public function formulaireAjoutresource(){
        echo '
             <form action="index.php?module=mod_enseignant&action=ajoutressource" method="POST">
                <h3>Ajout Ressource</h3>
                <table>
                    <tr>
                        <td>Nom :</td><td><input type="text" name="nomRessource" required></td>
                        <td>Type :</td><td><input type="text" name="typeRessource" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
        ';
    }

    public function formulaireAjoutdepot(){
        echo '
             <form action="index.php?module=mod_enseignant&action=ajoutdepot" method="POST">
                <h3>Ajout Depot</h3>
                <table>
                    <tr>
                        <td>Nom :</td><td><input type="text" name="nomDepot" required></td>
                        <td>Date de création:</td><td><input type="Date" name="DateCrea" required></td>
                        <td>Date de Limit:</td><td><input type="Date" name="DateLimi" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
        ';
    }

    public function listeressource($liste) {
        if (empty($liste)) {
            echo "<p>Aucune Ressource </p>";
            return;
        }
        echo '<h3> Liste Ressource </h3>';
        echo "<table>";
        foreach ($liste as $elem) {
            echo '<td>'  . htmlspecialchars($elem['nom']) . '</td>' .
                '<td><a href=index.php?module=mod_enseignant&action=consulterRessource&idressource=' . htmlspecialchars($elem['idRessource']) . '>' . htmlspecialchars($elem['type']) . '</a></td>';
        }
        echo "</table>";
    }

    public function listeDepot($liste) {
        if (empty($liste)) {
            echo "<p>Aucun Depot</p>";
            return;
        }
        echo '<h3> Liste Depot </h3>';
        echo "<table>";
        foreach ($liste as $elem) {
            echo 
            '<td>'  . htmlspecialchars($elem['nom']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['DateCreation']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['DateLimit']) . '</td>';
        }
        echo "</table>";
    }
    
}

?>