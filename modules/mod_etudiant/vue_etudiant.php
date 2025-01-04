<?php
class vue_etudiant {

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
                <input type="submit" value="Se déconnecter">
            </form>
        ';
    }

    public function vueGroupe($prenom) {
        $options = '';
        foreach ($prenom as $nom) {
            $options .= '<option value="' . htmlspecialchars($nom) . '">' . htmlspecialchars($nom) . '</option>';
        }

        echo '<button id="btnGroupe">Proposer un groupe</button>
        <div id="popUpGrp" style="display:none; border:1px solid black;">
            <form action="" method="post" id="formGroupe">
                <div class="form-option">
                    <label for="nom1">Étudiant 1 :</label>
                    <select name="nom">
                        ' . $options . '
                    </select><br>
                </div>
                
                <button type="button" id="ajouterEleve">Ajouter élève</button>
                <input type="submit" value="Proposer le groupe" id="envoyerGroupe">
            </form>
            <button id="close">Fermer</button>
        </div> 
        
        <script>
            let buttonGrp = document.getElementById("btnGroupe")
            buttonGrp.addEventListener("click", () => {
                document.getElementById("popUpGrp").style.display = "block"
            })
        
            let boutonClose = document.getElementById("close")
            boutonClose.addEventListener("click", () => {
                document.getElementById("popUpGrp").style.display = "none"
            })
        
            let form = document.getElementById("formGroupe")
            let bouttonEleve = document.getElementById("ajouterEleve")
            let optionsHTML = `' . addslashes($options) . '`
            let nbEleve = 1
        
            bouttonEleve.addEventListener("click", () => {
                if (nbEleve < 4) {
                    nbEleve++
                    let uniqueId = `nom${nbEleve}`
                    let option = document.createElement("div")
                    option.className = "form-option"
                    option.innerHTML = `
                        <label for="${uniqueId}">Étudiant ${nbEleve} :</label>
                        <select name="nom" id="${uniqueId}">
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
                let options = form.querySelectorAll(".form-option")
                let index = 1
                options.forEach(option => {
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