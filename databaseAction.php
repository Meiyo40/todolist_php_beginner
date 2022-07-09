<?php

require_once ("database.php");

function select()
{

    //Ici on choisit soit de tout affiché si aucune isntruction n'est donné, soit d'aller chercher un seul élément s'il existe
    if(isset($_POST["id"]))
    {
        return getFromId($_POST["id"]);
    }
    else
    {
        if($GLOBALS["debugMode"])
        {
            var_dump("databaseAction select getAll");
        }
        return getAll();
    }
}

function insert()
{
    //S'il manque une information, on n'execute rien!
    if(!isset($_POST["name"]))
    {
        return null;
    }

    $name = $_POST['name'];
    $isCompleted = 0; //une tâche est forcément incomplète à sa création
    $createdAt = date('Y-m-d H:i:s');

    $db = connect();
    $statement = $db->prepare("INSERT INTO `task`
        (name, is_completed, created_at) VALUES 
        (:name, :is_completed, :created_at)
    ");

    //on lie nos valeurs aux variables dans la requête
    $statement->bindValue(':name', $name, PDO::PARAM_STR);
    $statement->bindValue(':is_completed', $isCompleted, PDO::PARAM_BOOL);
    $statement->bindValue(':created_at', $createdAt);
    $result = $statement->execute();

    $statement->closeCursor();
    $db = null;

    return $result;
}

function delete()
{
    if(!isset($_POST['id']))
    {
        return null;
    }

    $id = $_POST['id'];

    if($GLOBALS["debugMode"])
    {
        var_dump("delete(". $id.")");
    }

    $db = connect();
    $statement = $db->prepare("DELETE FROM `task` WHERE `id` = :id;");
    $statement->bindValue(':id', $id);
    $result = $statement->execute();

    $statement->closeCursor();
    $db = null;

    $_POST = array(); //On supprime l'action, sinon la fonction getFromId sera appelé sur un élément qui n'existe plus !

    return getAll();
}

function update()
{
    if($GLOBALS["debugMode"])
    {
        var_dump(array("id" => $_POST["id"], "isCompleted" => $_POST["isCompleted"], "name" => $_POST["name"]));
    }

    //S'il manque une information, on n'execute rien!
    if(!isset($_POST["id"]) || !isset($_POST["isCompleted"]) || !isset($_POST["name"]))
    {
        return null;
    }

    $name = $_POST['name'];
    $isCompleted = (int)$_POST['isCompleted'];
    $id = (int)$_POST['id'];

    $db = connect();
    $statement = $db->prepare("UPDATE `task`
        SET name = :name, is_completed = :isCompleted
        WHERE id = :id
    ");

    //on lie nos nouvelles valeurs aux variables dans la requête
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':name', $name, PDO::PARAM_STR);
    $statement->bindValue(':isCompleted', $isCompleted, PDO::PARAM_BOOL);
    $result = $statement->execute();

    $statement->closeCursor();
    $db = null;

    return $result;
}

function getFromId($id)
{
    if(!isset($_POST['id']))
    {
        return null;
    }

    $id = $_POST['id'];

    if($GLOBALS["debugMode"])
    {
        var_dump("getFromId(". $id.")");
    }

    $db = connect();
    $statement = $db->prepare("SELECT*FROM `task` WHERE `id` = :id;");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $statement->closeCursor();
    $db = null;

    return $result;
}

function getAll()
{
    if($GLOBALS["debugMode"])
    {
        var_dump("getAll");
    }

    $db = connect();
    $statement = $db->prepare("SELECT*FROM `task`;");

    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement->closeCursor();
    $db = null;

    return $result;
}

function completeTask()
{
    if($GLOBALS["debugMode"])
    {
        var_dump(array("id" => $_POST["id"]));
    }

    //S'il manque une information, on n'execute rien!
    if(!isset($_POST["id"]))
    {
        return null;
    }

    $id = (int)$_POST['id'];

    $db = connect();
    $statement = $db->prepare("UPDATE `task`
        SET is_completed = 1
        WHERE id = :id
    ");

    //on lie nos nouvelles valeurs aux variables dans la requête
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $result = $statement->execute();

    $statement->closeCursor();
    $db = null;

    return $result;
}