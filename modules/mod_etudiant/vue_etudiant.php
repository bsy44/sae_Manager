<?php
class vue_etudiant{

    public function menu() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
            <input type="submit" value="Se déconnecter">
        ';
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