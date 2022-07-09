<?php

function connect(){

    $db_user = 'symfony';
    $db_pwd = 'symfony';
    $db_name = "simple_crud";
    $db_host = "localhost";
    $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name;

    try {
        $db_connect = new PDO($dsn, $db_user, $db_pwd);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $db_connect;
}
