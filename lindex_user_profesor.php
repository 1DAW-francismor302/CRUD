<?php

include_once('./libraries/functions.php');

//Inicialización
boot();

//Lógica de negocio
//Lee CSV
$usuarios = getDataFromCSV('./data/users.csv');

//Lógica de presentación
//Presenta el html a partir de los datos en el CSV
include_once('./templates/index_users.tpl.php');

$host = 'localhost';
$username = 'root';
$pswd = 'crud_mysql';
$db = 'crud_mysql';
$csvFile = './data/users.csv';

$conectar = new PDO ('mysql:host=localhost;dbname=crud_mysql','crud_mysql','crud_mysql');
?>