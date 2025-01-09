let form = document.getElementById("formGroupe");
let bouttonEleve = document.getElementById("ajouterEleve");
let nbEleve = 1;

bouttonEleve.addEventListener("click", () => {
    if (nbEleve < 4) {
        nbEleve++;
        let uniqueId = `nom${nbEleve}`;
        let option = document.createElement("div");
        option.className = "form-option";
        option.innerHTML = `
            <label for="${uniqueId}">Étudiant ${nbEleve} :</label>
            <select name="idEtu${nbEleve}" id="${uniqueId}">
                ${optionsHTML}
            </select>
        `;
        let boutonRetirer = document.createElement("button");
        boutonRetirer.type = "button";
        boutonRetirer.innerText = "X";
        boutonRetirer.addEventListener("click", () => {
            form.removeChild(option);
            nbEleve--;
            updateLabels();
        });
        option.appendChild(boutonRetirer);
        form.insertBefore(option, bouttonEleve);
    }
});

function updateLabels() {
    let optionsPrenom = form.querySelectorAll(".form-option");
    let index = 1;
    optionsPrenom.forEach(option => {
        let label = option.querySelector("label");
        let select = option.querySelector("select");
        let newId = `nom${index}`;
        label.innerText = `Étudiant ${index} :`;
        label.setAttribute("for", newId);
        select.id = newId;
        index++;
    });
}
