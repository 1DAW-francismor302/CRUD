<?php

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_error_handler("customError");

function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr";
}

$csvFile = 'users.csv';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No se ha especificado el ID del usuario.";
    exit;
}

$id = $_GET['id'];
$usuario = null;

$rows = [];
if (($archivo = fopen($csvFile, 'r')) !== false) {
    while (($data = fgetcsv($archivo, 1000, ',')) !== false) {
        if($data[0] == $id){
            $usuario = $data;
        }
    }
    fclose($archivo);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Detalles del usuario</title>
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
    <?php
      if ($usuario) {
          echo '<h2>Datos del usuario</h2>';
          echo '<p><strong>Nombre:</strong> ' . $usuario[1] . '</p>';
          echo '<p><strong>Email:</strong> ' . $usuario[2] . '</p>';
          echo '<p><strong>Rol:</strong> ' . $usuario[3] . '</p>';
          echo '<a class="btn" href="index.php">Volver</a>';
      } else {
          echo '<h2>No se ha encontrado el usuario</h2>';
          echo '<a class="btn" href="index.php">Volver</a>';
      }
    ?>
  </div>

</body>
</html>