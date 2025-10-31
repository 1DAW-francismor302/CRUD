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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "No se ha especificado el ID del usuario.";
    exit;
}

function leerCSV($csvFile, $id) {
  $rows = [];
  $usuarioData = null;


  if (($archivo = fopen($csvFile, 'r')) !== false) {
      while (($data = fgetcsv($archivo, 1000, ',')) !== false) {
          $rows[] = $data;
          if ($data[0] == $id) {
              $usuarioData = $data;
          }
      }
      fclose($archivo);
  }


  if (!$usuarioData) {
      echo "No se encontró un usuario con el ID indicado.";
      exit;
  }

  return array($rows, $usuarioData);
}

$resultadoCSV = leerCSV($csvFile, $id);
$rows = $resultadoCSV[0];
$usuarioData = $resultadoCSV[1];

leerPost($csvFile, $id, $rows);


function leerPost($csvFile, $id, $rows) {
  if (isset($_POST['usuario']) && isset($_POST['email']) && isset($_POST['rol'])) {
    $nuevoUsuario = $_POST['usuario'];
    $nuevoEmail = $_POST['email'];
    $nuevoRol = $_POST['rol'];

    
    $nuevosDatos = [];
    foreach ($rows as $data) {
        if ($data[0] == $id) {
            $data[1] = $nuevoUsuario;
            $data[2] = $nuevoEmail;
            $data[3] = $nuevoRol;
        }
        $nuevosDatos[] = $data;
    }


    if (($archivo = fopen($csvFile, 'w')) !== false) {
        foreach ($nuevosDatos as $data) {
            fputcsv($archivo, $data);
        }
        fclose($archivo);
    }

    
    header('Location: index.php');
    exit;
  }
}


function getFormularioMarkup($usuarioData) {
    $id = $usuarioData[0];
    $nombre = $usuarioData[1];
    $email = $usuarioData[2];

    return '
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="' . $id . '"/>
        <div class="form-group">
            <label for="exampleInputusername">Nombre de Usuario</label>
            <input type="text" name="usuario" class="form-control" id="exampleInputusername" value="' . $nombre . '" required/>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="' . $email . '" required/>
        </div>
        <div class="form-group">
           <label for="roleSelect">Rol</label>
            <select id="roleSelect" name="rol" class="form-control">
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
                <option value="moderator">Moderador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
    <br>
    <button class="btn index"><a href="index.php">Volver al índice</a></button>
    ';
}

$formularioMarkup = getFormularioMarkup($usuarioData);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Usuario</title>
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    form {
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      width: 320px;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    select {
      width: 100%;
      padding: 0.6rem 1rem;
      border: 1.8px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.3s;
      box-sizing: border-box;
    }

    input:focus,
    select:focus {
      border-color: #3f51b5;
      outline: none;
      box-shadow: 0 0 8px rgba(63,81,181,0.3);
    }

    button.btn {
      width: 100%;
      padding: 0.75rem;
      background-color: #3f51b5;
      color: white;
      font-size: 1rem;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button.btn:hover {
      background-color: #2c3e9e;
    }

    button.index a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div>
    <?php echo $formularioMarkup; ?>
  </div>
</body>
</html>