<?php

require_once ("databaseAction.php");

function isUserLoggedIn() {

    if(isset($_POST["disconnect"])) //Si la commande disconnect est post, on déco.
    {
        logout();
        return false;
    }

    //pas de session pas de post d'identifiant ? ca nous intéresse pas !
    if(!isset($_SESSION['user']) && !isset($_POST["username"]) && !isset($_POST["password"]))
    {
        return false;
    }

    if(isset($_SESSION['user']))
    {
        return true;
    }

    //pas de ssion mais post de login, on va donc vérifier s'il peut être connecté.
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        return login();
    }

    return false;
}

function login()
{
    $MY_USERNAME = "admin";
    $MY_PASSWORD = "azerty"; // on remplacerait bien sûr ça par une table en base de donnée...
    //Pourquoi ne pas rajouter ce bout de code vous même ??

    if($_POST["username"] == $MY_USERNAME && $_POST["password"] == $MY_PASSWORD)
    {
        $date = new DateTime();

        $_SESSION['user'] = $MY_USERNAME;
        setcookie("user", $MY_USERNAME);
        setcookie("connected_at", $date->format("H:i:s d-m-Y"));
        return true;
    }
    else
    {
        return false;
    }
}

function logout()
{
    //on déconnecte l'utilisateur en détruisant la session et les cookies.
    unset($_COOKIE["user"]);
    unset($_COOKIE["connected_at"]);
    session_destroy();
}

function getContent()
{
    return databaseAction("select");
}

function doAction()
{
    if(isset($_POST['index']))
    {
        $_GET = array();
        $_POST = array(); // On reset le post pour ne plus avoir de parasite et revenir à la page index.
        header("Location: /");
    }


    //S'il ya une action de set dans l'url, on envoi cette commande.
    if(isset($_GET['action']))
    {
        return databaseAction($_GET['action']);
    }

    //sinon on envoi select par défaut.
    return databaseAction("select");
}

function databaseAction($action) //On passe l'action à cette fonction, elle redirigera ensuite vers la bonne fonction.
{
    switch($action)
    {
        case "complete":
            return completeTask();
        case "create":
            return insert();
        case "update":
            return update();
        case "delete":
            return delete();
        case "select":
            return select();
        default:
            print_r("Error, unknow action");
            return null;
    }
}