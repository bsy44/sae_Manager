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



    public function affichelisteSAE($titre, $liste) {
        if (empty($liste)) {
            echo '<p>Aucun  SAE ' . $titre . '</p>';
            return;
        }
        echo '<h3> Liste SAE ' . $titre .  '</h3>'; 
        echo "<table>";
        foreach ($liste as $projet) {
            echo '<td><a href=index.php?module=mod_etudiant&action=consultsae&idprojet=' . htmlspecialchars($projet['idProjet']) . '>' . htmlspecialchars($projet['intitule']) . '</a></td>';
        }
        echo "</table>";
    }

    
    
}
?>
