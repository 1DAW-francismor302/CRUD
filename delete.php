<?php

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_error_handler("customError");

include_once('./libraries/functions.php');

function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr";
}


$csvFile = 'users.csv';

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "No se ha especificado el ID del usuario a borrar.";
}

$idABorrar = $_POST['id'];

$usuarios = showBD();

$usuarioEncontrado = false;

foreach ($usuarios as $usuario) {
  if ($usuario['id'] == $idABorrar) {
    $usuarioEncontrado = true;
  }
}

deleteUser($idABorrar);

// $rows = [];
// $usuarioEncontrado = false;
// if (($archivo = fopen($csvFile, 'r')) !== false) {
//     while (($data = fgetcsv($archivo, 1000, ',')) !== false) {
//         if($data[0] != $idABorrar){
//             $rows[] = $data;
//         }else{
//             $usuarioEncontrado = true;
//         }
//     }
//     fclose($archivo);
// }

// if (($archivo = fopen($csvFile, 'w')) !== false) {
//     foreach ($rows as $row) {
//         fputcsv($archivo, $row);
//     }
//     fclose($archivo);
// }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Índice de Usuarios</title>
    <style>
        body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 350px;
      text-align: center;
    }

    h2 {
      color: #3f51b5;
      margin-bottom: 1rem;
    }

    p {
      margin: 0.5rem 0;
      color: #333;
    }

    .btn {
      margin-top: 1.5rem;
      display: inline-block;
      padding: 0.6rem 1.2rem;
      background-color: #3f51b5;
      color: white;
      border: none;
      border-radius: 6px;
      text-decoration: none;
    }

    .btn:hover {
      background-color: #2c3e9e;
    }
  </style>
</head>
<body>

    <div class="card">
        <h2> <?php
        if($usuarioEncontrado){
          echo "<p style='color:green;'>Usuario borrado correctamente</p>";
        }
        ?>
        </h2>
        <botton>
            <a class = "btn" href="index.php">Volver al índice</a>
        </botton>
    </div>    

</body>
</html>


