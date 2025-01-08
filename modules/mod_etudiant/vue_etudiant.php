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

    public function affichelisteSAE($titre, $liste) {
        if (empty($liste)) {
            echo '<p>Aucun  SAE ' . $titre . '</p>';
            return;
        }
        echo '<h3> Liste SAE ' . $titre .  '</h3>'; 
        echo "<table>";
        foreach ($liste as $projet) {
            echo '<td><a href=index.php?module=mod_etudiant&action=formGroupe&idprojet=' . htmlspecialchars($projet['idProjet']) . '>' . htmlspecialchars($projet['intitule']) . '</a></td>';
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
            <button id="close">Fermer</button>
        </div> 
        
        <script>
            let boutonClose = document.getElementById("close")
            boutonClose.addEventListener("click", () => {
                document.getElementById("popUpGrp").style.display = "none"
            })
        
            let form = document.getElementById("formGroupe")
            let bouttonEleve = document.getElementById("ajouterEleve")
            let optionsHTML = `' . addslashes($optionsPrenom) . '`
            let nbEleve = 1
        
            bouttonEleve.addEventListener("click", () => {
                if (nbEleve < 4) {
                    nbEleve++
                    let uniqueId = `nom${nbEleve}`
                    let option = document.createElement("div")
                    option.className = "form-option"
                    option.innerHTML = `
                        <label for="${uniqueId}">Étudiant ${nbEleve} :</label>
                        <select name="idEtu${nbEleve}">
                            ${optionsHTML}
                        </select>
                    `
                    let boutonRetirer = document.createElement("button")
                    boutonRetirer.type = "button"
                    boutonRetirer.innerText = "X"
                    boutonRetirer.addEventListener("click", () => {
                        form.removeChild(option)
                        nbEleve--
                        updateLabels()
                    })
                    option.appendChild(boutonRetirer)
                    form.insertBefore(option, bouttonEleve)
                }
            })
        
            function updateLabels() {
                let optionsPrenom = form.querySelectorAll(".form-option")
                let index = 1
                optionsPrenom.forEach(option => {
                    let label = option.querySelector("label")
                    let select = option.querySelector("select")
                    let newId = `nom${index}`
                    label.innerText = `Étudiant ${index} :`
                    label.setAttribute("for", newId)
                    select.id = newId
                    index++
                })
            }
        </script>
        ';
    }
    
}
?>
