<?php
class vue_enseignant
{

    public function acceuil()
    {
        echo '
    <div id="enseignant-page">
        <header id="enseignant-header" class="d-flex justify-content-between align-items-center p-3">
               <a href="index.php" id="enseignant-logo" style="text-decoration: none; color: white;">
            <h1 id="enseignant-logo">SAE Manager</h1>
                </a>
            
            <div id="enseignant-menu" class="d-flex align-items-center">
                <a href="index.php?module=mod_connexion&action=deconnexion" id="logout-icon">
                    <i class="bi bi-box-arrow-right" title="Se déconnecter" aria-label="Se déconnecter"></i>
                </a>
            </div>
        </header>

        <main id="enseignant-main" class="p-4">
            <h2 id="enseignant-welcome">Bonjour !</h2>
            
         <div id="enseignant-sae-container" class="mt-4">
    <div class="add-button-container">
    <a href="index.php?module=mod_enseignant&action=btnajoutsae" class="add-button">
        +
        <span class="add-button-text">Ajouter SAE</span>
    </a>
       </div>

    <hr class="sae-separator">
</div>';


        $modele = new modele_enseignant();
        $login = $_SESSION['login']; // Récupère l'identifiant de l'utilisateur connecté

        // Affiche les SAE dynamiques
        $this->affichelisteSAE("EN COURS", $modele->getlisteSAEencours($login));
        $this->affichelisteSAE("A VENIR", $modele->getlisteSAEavenir($login));
        $this->affichelisteSAE("TERMINÉ", $modele->getlisteSAEtermine($login));

        echo '
            </div>
        </main>

        <footer id="enseignant-footer" class="d-flex justify-content-center align-items-center p-3">
            <p>&copy;2025 | Groupe 14 | Tous droits réservés.</p>
        </footer>
    </div>';
    }
    
    public function formulaireAjoutSAE($listeSemestre, $listeEnseignant){
        $optionsSemestre = '';
        foreach ($listeSemestre as $elem) {
            $optionsSemestre .= '<option value="' . htmlspecialchars($elem["semestre"]) . '">' . htmlspecialchars($elem["semestre"]) . '</option>';
        }
        $optionsPrenom = '';
        foreach ($listeEnseignant as $enseignant) {
            $optionsPrenom .= '<option value="' . htmlspecialchars($enseignant["idEns"]) . '">' . htmlspecialchars($enseignant["prenom"]) . '</option>';
        }
        echo '<div class="page-ajout-sae">
    <div class="form-container">
        <h2>Ajouter SAE</h2>
        <form action="index.php?module=mod_enseignant&action=ajoutsae" method="POST">
            <div class="form-group">
                <label for="intitule">Intitulé :</label>
                <input type="text" id="intitule" name="intitule" placeholder="Entrez le titre" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <input type="text" id="description" name="description" placeholder="Description du SAE" required>
            </div>
            <div class="form-group">
                <label for="lien">Lien :</label>
                <input type="text" id="lien" name="lien" placeholder="Lien associé" required>
            </div>
            
            <div class="form-group">
                <label for="semestre">Semestre :</label>
                <select name="semestre" id="semestre" >' . $optionsSemestre . '</select> 
            </div>
            <div class="form-group">
                <label for="coresponsable">coresponsable :</label>
                <select name="coresposable" id = "coresposable">' . $optionsPrenom . '</select>
            </div>

            <div class="form-group">
                <label for="DateDebut">Date de début :</label>
                <input type="date" id="DateDebut" name="DateDebut" required>
            </div>
            <div class="form-group">
                <label for="DateFin">Date de fin :</label>
                <input type="date" id="DateFin" name="DateFin" required>
            </div>
            <div class="form-buttons">
                 <button type="button" class="btn-cancel" onclick="window.history.back()">Annuler</button>
                 <button type="submit" class="btn-submit">Ajouter</button>
            </div>
        </form>
    </div>
</div>';
    }


    public function affichelisteSAE($titre, $liste)
    {
        echo '<section class="sae-section mb-4">';
        echo '<h3 class="sae-section-title">' . htmlspecialchars($titre) . '</h3>';

        if (empty($liste)) {
            echo '<p>Aucune SAE ' . htmlspecialchars($titre) . '</p>';
        } else {
            echo '<div class="sae-list">';
            foreach ($liste as $projet) {
                echo '<a href="index.php?module=mod_enseignant&action=consultsae&idprojet=' . htmlspecialchars($projet['idProjet']) . '" class="sae-item">' . htmlspecialchars($projet['intitule']) . '</a>';
            }
            echo '</div>';
        }

        echo '</section>';
    }


    public function outilsAjout()
    {
       echo '
            <div id="header-buttons">
            <button id="btn-add-resource" onclick="location.href=\'index.php?module=mod_enseignant&action=btnajoutressource\'">Ajouter Ressource</button>
            <button id="btn-add-depot" onclick="location.href=\'index.php?module=mod_enseignant&action=btnajoutdepot\'">Ajouter Dépot</button>
            <button id="btn-add-intervenant" onclick="location.href=\'index.php?module=mod_enseignant&action=btnajoutintervenant\'">Ajouter Intervenant</button>
            <button id="btn-consulter-grp-temporaire" onclick="location.href=\'index.php?module=mod_enseignant&action=groupeTemporaire\'">Groupe en attente de validation</button>
        </div>

       ';
    }

    public function formulaireAjoutresource()
    {
        echo '
             <form action="index.php?module=mod_enseignant&action=ajoutressource" method="POST">
                <h3>Ajout Ressource</h3>
                <table>
                    <tr>
                        <td>Nom :</td><td><input type="text" name="nomRessource" required></td>
                        <td>Lien :</td><td><input type="text" name="lienRessource" required></td>
                        <td><input type="submit" value="Ajouter"></td>
                    </tr>
                </table>
            </form>
        ';
    }

    public function formulaireAjoutdepot()
    {
        echo '
             <form action="index.php?module=mod_enseignant&action=ajoutdepot" method="POST">
                <h3>Ajout Dépot</h3>
                <table>

                    <tr>
                        <td>Nom :</td><td><input type="text" name="nomDepot" required></td>
                        <td>Date de publication:</td><td><input type="Date" name="DatePubli" required></td>
                        <td>Date de Limite:</td><td><input type="Date" name="DateLimi" required></td>
                        <td>Description :</td><td><input type="text" name="descriptionDepot" ></td>
                       
                    </tr>
                    <td><input type="submit" value="Ajouter"></td>
                </table>
            </form>
        ';
    }

    public function affichelisteIntervenant($liste)
    {
        echo '<h3> Liste Intervenant </h3>';
        if (empty($liste)) {
            echo "Aucun Intervenant";
        } else {
            echo "<table> 
        <tr><th >Nom</th>
        <th >Prénom</th></tr>";

            foreach ($liste as $elem) {
                echo
                    '<tr><td>' . htmlspecialchars($elem['nom']) . '</td>' .
                    '<td>' . htmlspecialchars($elem['prenom']) . '</td>
                     <form action="index.php?module=mod_enseignant&action=supInterveanant" method="POST">
                    <td> <input type="hidden" name="idEns" value="' . htmlspecialchars($elem['idEns']) . '"><button id="btn-delete-sae" type="submit">Supprimer</button> </td></form>
                    </tr>';

            }
            echo "</table>";
        }
    }

    public function formulaireAjoutIntervenant($liste)
    {
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

//    public function listeressource($lisInterte)
//    {
//
//
//        if (empty($liste)) {
//            echo "<p>Aucune Ressource</p>";
//            return;
//        }
//        echo '<h3> Liste Ressource </h3>';
//        echo "<table>
//        <tr>
//        <th >Nom</th>
//        <th >Lien</th>
//        </tr>";
//
//        foreach ($liste as $elem) {
//            echo
//                '<tr><td>' . htmlspecialchars($elem['nom']) . '</td>' .
//                '<td>' . htmlspecialchars($elem['lien']) . '</td></tr>';
//        }
//        echo "</table>";
//    }
//
//    public function listeDepot($liste)
//    {
//        if (empty($liste)) {
//            echo "<p>Aucun Depot</p>";
//            return;
//        }
//        echo '<h3> Liste Depot </h3>';
//        echo "<table>
//        <tr>
//        <th >Nom</th>
//        <th >Date de Publication</th>
//        <th >Date Limite</th>
//        </tr>";
//
//        foreach ($liste as $elem) {
//            echo
//
//                '<tr><td>' . htmlspecialchars($elem['nom']) . '</td>' .
//                '<td>' . htmlspecialchars($elem['datePublication']) . '</td>' .
//                '<td>' . htmlspecialchars($elem['dateLimite']) . '</td>' .
//                '<td>' . htmlspecialchars($elem['description']) . '</td></tr>';
//        }
//        echo "</table>";
//    }

//ajout de ca pour detailsae
    public function detailsSae($ressources, $depots)
    {
        echo '
    <div id="enseignant-headerdetail" class="header">
        <div id="logo-container">
        <a href="index.php" id="enseignant-logo">
            <h1>SAE Manager</h1>
        </a>
        </div>
        
    </div>

    <div id="enseignant-main">
        <div id="resources-section">
            <h2 id="resources-title">Liste des Ressources</h2>
            <table id="resources-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Lien</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($ressources)) {
            echo '<tr><td colspan="2" style="text-align: center;">Vide</td></tr>';
        } else {
            foreach ($ressources as $ressource) {
                echo '<tr><td>' . htmlspecialchars($ressource['nom']) . '</td><td>' . htmlspecialchars($ressource['lien']) . '</td></tr>';
            }
        }

        echo '
                </tbody>
            </table>
        </div>

        <div id="deposits-section">
            <h2 id="deposits-title">Liste des Dépots</h2>
            <table id="deposits-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de Publication</th>
                        <th>Date Limite</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($depots)) {
            echo '<tr><td colspan="4" style="text-align: center;">Vide</td></tr>';
        } else {
            foreach ($depots as $depot) {
                echo '<tr><td>' . htmlspecialchars($depot['nom']) . '</td><td>' . htmlspecialchars($depot['datePublication']) . '</td><td>' . htmlspecialchars($depot['dateLimite']) . '</td><td>' . htmlspecialchars($depot['description']) . '</td></tr>';
            }
        }

        echo '
                </tbody>
            </table>
        </div>
    </div>

        <form action="index.php?module=mod_enseignant&action=supprimerSae" method="POST">
            <input type="hidden" name="idProjet" value="' . htmlspecialchars($_SESSION['idProjet']) . '">
            <button id="btn-delete-sae" type="submit">Supprimer SAE</button>
        </form>';
    }

    public function consulterGroupeProposer($liste) {
        if ($liste == null) {
            echo "<p>Aucun groupe proposé</p>";
            return;
        }

        $groupesAffiches = [];
        $i = 1;
        echo "<p>Voici les groupes qui vous ont été proposés pour cette SAÉ :</p>";

        foreach ($liste as $groupe) {
            $idGroupe = $groupe["idGroupe"];

            if (!in_array($idGroupe, $groupesAffiches)) {
                echo '<a href="index.php?module=mod_enseignant&action=detailGroupe&id=' . $idGroupe . '">Groupe ' . $i . '</a><br>';
                $groupesAffiches[] = $idGroupe;
                $i++;
            }
        }
    }

    public function afficheDetail($groupe) {
        echo "<ul>";
        foreach ($groupe as $etudiant) {
            echo "<li>" . $etudiant["nom"] . " " . $etudiant["prenom"] . "</li>";
        }
        echo "</ul>";

        echo "
            <form action='index.php?module=mod_enseignant&action=validationGroupe' method='POST'>
            <input type='hidden' name='idGroupe' value='" . $groupe[0]["idGroupe"] . "'>
            <input type='hidden' name='idProjet' value='" . $groupe[0]["idProjet"] . "'>
        ";
        foreach ($groupe as $etudiant) {
            echo "<input type='hidden' name='idEtudiants[]' value='" .$etudiant["idEtudiant"] . "'>";
        }

        echo "
            <button type='submit' name='action' value='Accepter groupe' id='bouttonAccepter'>Accepter groupe</button>
            <button type='submit' name='action' value='Refuser groupe' id='bouttonRefuser'>Refuser groupe</button>
            </form>
        ";

        echo "<a href='index.php?module=mod_enseignant&action=consulterGroupe'>Retour</a>";
    }


}
?>