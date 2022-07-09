<h1> <?php echo "Hello " . $_COOKIE["user"] . " you are connected since: " . $_COOKIE["connected_at"] ?></h1>


<?php
    function ShowTask($task) // cette fonction permettra d'afficher le html de la tâche désiré
    {
        $checked = "";

        if((int)$task["is_completed"])
        {
            $checked = "checked";
        }

        echo "
            <div class='task'>
                <br>
                <input name='name' id='input-name-" . $task["id"] .  "' value='" . $task["name"] . " (" . $task["id"] . ")'>
                
                <div>
                    <label for='isCompleted'>Complété: </label>
                    <input type='checkbox' name='isCompleted' id='input-status-" . $task["id"] .  "' class='task-status' " . $checked . " value='" . $task["is_completed"] . "'>
                </div>
                
                <span>" . $task["created_at"] . "</span>      
                
                <div class='task-actions'>
                    
                    <form method='post' action='index.php?action=update'>
                        <input type='hidden' name='id' value='" . $task["id"] . "'>                            
                        <input name='name' id='input-update-name-" . $task["id"] .  "' type='hidden' value='" . $task["name"] . " (" . $task["id"] . ")'>
                        <input name='isCompleted' id='input-update-status-" . $task["id"] .  "' class='task-status' type='hidden' " . $checked . "  value='" . $task["is_completed"] . "'>
                        <button type='submit' class='updateButton btn' id='" . $task["id"] .  "' name='update'>Modifier</button>
                    </form>
            
                    <!-- 
                        Cas particulier de la modification, on voudrait pouvoir changer le nom de la tâche ou si elle est complète, pourquoi pas.
                        
                        On a bien créé un bouton compléter qui va directement demander à mettre à jour la tâche, mais ce nest pas assez flexible.
                        
                        On voudrait par exemple, changer le nom, ou même dire que la tâche n'est fianlement pas complète.
                        
                        Y'a plein de façon de faire ça, mais je vais choisir de faire un bout de javascript pour montrer une des possibilités.
                                                  
                        Rendez vous dans le fichier update.js pour la suite.
                     
                     -->
                                  
                    <form method='post' action='?action=complete'>
                        <input type='hidden' name='id' value='" . $task["id"] ."'>  <!-- Champ invisible pour passer les parametres du form, ici l'id de la tache -->
                        <button class='btn btn-complete' type='submit'>Compléter</button>
                    </form>
                    <form method='post' action='?action=delete'>
                        <input type='hidden' name='id' value='" . $task["id"] ."'> <!-- Champ invisible pour passer les parametres du form, ici l'id de la tache -->
                        <button class='btn btn-delete' type='submit'>Supprimer</button>
                    </form>
                </div>
            </div>
        ";
    }
?>



<div id="todolist-container">


    <div id="new-task-container">
        <form method="post" action="index.php?action=create">
            <label for="name">Nom: </label>
            <input name="name" type="text" id="name" placeholder="Nom de votre nouvelle tâche" required>
            <button class="btn btn-add" type="submit">Ajouter tâche</button>
        </form>
    </div>

    <div id="task-container">
        <?php

        if(isset($tasks)) // Si on a récupéré des tâches, on va afficher tout ça.
        {
            //var_dump($tasks); //utilisé pour afficher les tâches

            //petit trick, si on veut savoir si c'est un tableau venant du getAll ou du GetFromId
            //dans le cas du getall "id" ne sera forcément pas set, ca evite d'appeler le foreach sur le mauvais élément.
            //si on utilisait le foreach pour le retour du getFromId, cela parcourerais les colonnes 1 à 1, et la fonction ShowTask ne fonctionnerait pas
            if(!isset($tasks["id"]))
            {
                foreach($tasks as $task)
                {
                    ShowTask($task);
                }
            }
            else {
                ShowTask($tasks);
            }
        }

        ?>
    </div>

</div>


<div id="foot-navbar">
    <form method="post" action="">
        <input type="hidden" name="disconnect" value="1">
        <button>Disconnect</button>
    </form>
    <form method="post" action="">
        <input type="hidden" name="index" value="1">
        <button>Index</button>
    </form>
</div>


<script src="./update.js"></script>