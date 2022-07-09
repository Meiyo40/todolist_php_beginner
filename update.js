/*
* Rebonjour, on va maintenant se faire un petit script pour mettre à jour notre tâche !
*
* On va commencer par utiliser le document.getElement pour récupérer ce que l'on souhaite.
*
* On va également mettre à jours nos inputs invisible du formulaire update pour qu'ils récupèrent les infos des inputs visible
* C'est pas vraiment la meilleure façon de faire, mais ça marche et ca reste relativement simple pour utiliser des formulaires.
* */

let updateButtons = document.getElementsByClassName("updateButton");

for(let i = 0; i < updateButtons.length; i++) {
    let taskId = updateButtons[i].id; // petite triche, normalement on ferait pas comme ça, mais ici je vais me servir de l'id du bouton pour transmettre l'id de la tâche
    let inputName = document.getElementById("input-name-"+taskId);     //Champ visible que l'on va écouter
    let inputStatus = document.getElementById("input-status-"+taskId); // champ visible que l'on va écouter

    let inputNameUpdate = document.getElementById("input-update-name-"+taskId);
    let inputStatusUpdate = document.getElementById("input-update-status-"+taskId);

    inputName.addEventListener("input", (e) => {
        inputNameUpdate.value = e.target.value;
        console.log(inputNameUpdate.value);
    });

    inputStatus.addEventListener("change", (e) => { //Checkbox, donc on va voir différente chose.
        inputStatusUpdate.checked = e.target.checked;
        //les checkbox peuvent avoir une value, mais la grosse différence, c'est si elles sont "checked" ou non,
        //c'est un attribut qui se rajoutent dans le html, vous pouvez le voir en utilisant la console sur le debug ou en regardant le html
        inputStatusUpdate.value = e.target.checked ? 1 :0;
        //on place par exemple comme ici une value en lien avec l'état de la checkbox
        //On en avait rapidement parlé, mais ici j'ai utilisé une ternaire, c'est un simple if mais plus court
        //ici on peut lire => if checked then return 1 else return 0
        console.log(inputStatusUpdate.checked);
    })
}