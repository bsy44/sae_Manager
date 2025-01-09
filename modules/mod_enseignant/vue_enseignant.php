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
                        <td>Date de début:</td><td><input type="Date" name="DateDebut" required></td>
                        <td>Date de fin:</td><td><input type="Date" name="DateFin" required></td>
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
    
    public function affichelisteSAE($titre, $liste) {
        if (empty($liste)) {
            echo '<p>Aucun SAE ' . $titre . '</p>';
            return;
        }
        echo '<h3>' . $titre . '</h3>'; 
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
        <form action="index.php?module=mod_enseignant&action=btnajoutintervenant" method="POST">
            <input type="submit" value="Ajouter Intervenant">
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
                        <td>lien :</td><td><input type="text" name="lienRessource" required></td>
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
                        <td>Date de publication:</td><td><input type="Date" name="DatePubli" required></td>
                        <td>Date de Limit:</td><td><input type="Date" name="DateLimi" required></td>
                        <td>Description :</td><td><input type="text" name="descriptionDepot" ></td>
                       
                    </tr>
                    <td><input type="submit" value="Ajouter"></td>
                </table>
            </form>
        ';
    }

    public function affichelisteIntervenant($liste){
        echo '<h3> Liste Intervenant </h3>';
        if(empty($liste)){
            echo "Aucun Intervenant";
        }
        else{
        echo "<table> 
        <tr><th >Nom</th>
        <th >prenom</th></tr>";
        
        foreach ($liste as $elem) {
            echo 
            '<tr><td>' . htmlspecialchars($elem['nom']) . '</td>' .
            '<td>'. htmlspecialchars($elem['prenom']) . '</td></tr>';
        }
        echo "</table>";
    }   
    }

    public function formulaireAjoutIntervenant($liste){
        $optionsPrenom = '';
        foreach ($liste as $enseignant) {
            $optionsPrenom .= '<option value="' . htmlspecialchars($enseignant["idEns"]) . '">' . htmlspecialchars($enseignant["prenom"]) . '</option>';
        }
        echo '
            <h3> Ajouter un Intervenant </h3>
             <form action="index.php?module=mod_enseignant&action=ajoutIntervenant" METHOD="post">
                <label for="nom"> Chosisiez un nom :</label>
                    <select name="idens">
                        ' . $optionsPrenom . '
                    </select>
                <input type="submit" value="Ajouter" >
            </form>
        ';
    }   

    public function listeressource($liste) {

        
        if (empty($liste)) {
            echo "<p>Aucune Ressource</p>";
            return;
        }
        echo '<h3> Liste Ressource </h3>';
        echo "<table> 
        <tr>
        <th >Nom</th>
        <th >Lien</th>
        </tr>";
        
        foreach ($liste as $elem) {
            echo 
            '<tr><td>'  . htmlspecialchars($elem['nom']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['lien']) . '</td></tr>';
        }
        echo "</table>";
    }

    public function listeDepot($liste) {
        if (empty($liste)) {
            echo "<p>Aucun Depot</p>";
            return;
        }
        echo '<h3> Liste Depot </h3>';
        echo "<table> 
        <tr>
        <th >Nom</th>
        <th >Date de Publication</th>
        <th >Date Limite</th>
        </tr>";
        
        foreach ($liste as $elem) {
            echo 
            
            '<tr><td>'  . htmlspecialchars($elem['nom']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['datePublication']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['dateLimite']) . '</td>' .
            '<td>'  . htmlspecialchars($elem['description']) . '</td></tr>';
        }
        echo "</table>";
    }
    
}

?>