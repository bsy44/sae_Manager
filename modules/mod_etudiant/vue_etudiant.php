<?php
class vue_etudiant {

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
    
            echo "
            <li>
            <a href=index.php?module=mod_etudiant&action=consulterdepot&iddepot={$depot['idDepot']} >
            Nom : {$depot['nom']}
            Date Limite : {$depot['dateLimite']}
            Description :{$depot['description']} 
            </a>
            </li>";
        }
        echo "</ul>";
    }
   
    public function afficherFormulaireDepot() {
        echo "<h1>Déposer un fichier</h1>";
        echo "<form method='POST' enctype='multipart/form-data'>";
        echo "<label>Fichier :</label><input type='file' name='fichier' required><br>";
        echo "<button type='submit'>Déposer</button>";
    }

    public function affichelisteSAE($titre, $liste, $action) {
        if (empty($liste)) {
            echo '<p>Aucun  SAE ' . $titre . '</p>';
            return;
        }
        echo '<h3> Liste SAE ' . $titre .  '</h3>'; 
        echo "<table>";
        foreach ($liste as $projet) {
            echo '<td><a href=index.php?module=mod_etudiant&action=' . $action .'&idprojet=' . htmlspecialchars($projet['idProjet']) . '>' . htmlspecialchars($projet['intitule']) . '</a></td>';
        }
        echo "</table>";
    }

    public function formGroupe($etudiant) {
        $optionsPrenom = '';
        foreach ($etudiant as $etudiants) {
            $optionsPrenom .= '<option value="' . htmlspecialchars($etudiants["idEtu"]) . '">' . htmlspecialchars($etudiants["prenom"]) . '</option>';
        }

        echo '
        <div id="popUpGrp">
            <form action="index.php?module=mod_etudiant&action=envoieProp" METHOD="post" id="formGroupe">
                <div class="form-option">
                    <label for="nom">Étudiant 1 :</label>
                    <select name="idEtu1">
                        ' . $optionsPrenom . '
                    </select><br>
                </div>
                
                <button type="button" id="ajouterEleve">Ajouter élève</button>
                <input type="submit" value="Proposer le groupe" id="envoyerGroupe">
            </form>
        </div> 
        
        <script>
            let optionsHTML = `' . addslashes($optionsPrenom) . '`
        </script>

        ';
    }

    public function affichcheckllist($liste){
        echo'
            <fieldset>
            <legend>Check List</legend>';

            foreach($liste as $elem){
                echo'
                <div>
                    <input type=checkbox>
                    <label>'. htmlspecialchars($elem['msg']) . '</label>
                </div>
                ';
            }
        
            echo '
            <form action="index.php?module=mod_etudiant&action=ajoutcheckbox" METHOD="post" ">
            <input type=checkbox><input type = text name=checkboxmsg></fieldset><input type="submit" value=ajouter></form>';
        
    }
}
?>
