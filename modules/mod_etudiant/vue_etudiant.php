<?php
class vue_etudiant {

    public function formualire() {
        echo '
            <form action="index.php?module=mod_connexion&action=deconnexion" method="POST">
                <input type="submit" value="Se déconnecter">
            </form>
        ';
    }

    public function formGroupe($prenom) {
        $optionsPrenom = '';
        foreach ($prenom as $nom) {
            $optionsPrenom .= '<option value="' . htmlspecialchars($nom) . '">' . htmlspecialchars($nom) . '</option>';
        }

        echo '<button id="btnGroupe">Proposer un groupe</button>
        <div id="popUpGrp" style="display:none; border:1px solid black;">
            <form action="index.php?module=mod_enseignant&action=validationGroupe" METHOD="post" id="formGroupe">
                <label for="sae">Saé :</label>
                <select name="saé">
                    <option value="SAE 3.2 POO">SAE 3.2 POO</option>
                    <option value="SAE 3.2 WEB">SAE 3.2 WEB</option>
                    <option value="S4.A.01">S4.A.01</option>
                    <option value="S4.C.01">S4.A.01 BD</option>
                </select><br>
                    
                <div class="form-option">
                    <label for="nom1">Étudiant 1 :</label>
                    <select name="nom">
                        ' . $optionsPrenom . '
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