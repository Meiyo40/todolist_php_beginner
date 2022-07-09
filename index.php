<?php
session_start();

//Ca permet de faire une trace du fil d'execution en utilisant des vardump dans les méthode, a ne pas utiliser sur des gros projets de cette façon.
$GLOBALS["debugMode"] = false;

require_once("manager.php");

if(isUserLoggedIn())  //On appelle une fonction qui va vérifier si l'utilisateur est connecté ou s'il a donné des identifiants, si oui, on prépare les informations de la page
{
    $page = "todolist.php";
    $title = "My Todo List Page";
    $result = doAction();
    $tasks = getContent();
}
else //Si l'utilisateur n'est pas connecté ou que les identifiants sont incorrect on le renvoi sur la page de connexion
{
    $page = "loginPage.php";
    $title = "My Login Page";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style.css">
    <title><?php echo $title ?></title>
</head>
<body>
    <div id="main">
        <?php

        include($page); // On inclut la page voulu (loginPage ou todolist) en fonction du if else en haut de page.

        ?>
    </div>
</body>
</html>