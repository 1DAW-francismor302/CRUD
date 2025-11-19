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

function dump($var){
  echo '<pre>'.print_r($var,1).'</pre>';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "No se ha especificado el ID del usuario.";
    exit;
}

$usuariosData = getUsuarios();
$usuarioData = '';

foreach ($usuariosData as $usuario) {
  if ($usuario['id'] == $id) {
    $usuarioData = $usuario;
  }
}


function leerPost($id) {
  if (isset($_POST['enviar'])) {
    $userData = filter_input_array(INPUT_POST,[
      'usuario' => FILTER_DEFAULT,
      'email' => FILTER_VALIDATE_EMAIL,
      'rol' => FILTER_DEFAULT
    ]);

    if (!empty($userData)) {
      $nuevoUsuario = $userData['usuario'];
      $nuevoEmail = $userData['email'];
      $nuevoRol = $userData['rol'];

      $nuevosDatos = array(
        'nombre' => $nuevoUsuario,
        'email' => $nuevoEmail,
        'rol' => $nuevoRol
      );

      if ($userData['email'] != $nuevosDatos['email']) {
        updateUser($id, $nuevosDatos);
      }else {
        alert("No se puede repetir el email");
      }
      header('Location: index.php');
      exit;
    }
  }
}

leerPost($id);


function getFormularioMarkup($usuarioData) {
    $id = $usuarioData['id'];
    $nombre = $usuarioData['nombre'];
    $email = $usuarioData['email'];
    $rol = $usuarioData['rol'];

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
                <option value="admin" '.($rol=='admin'?'selected':'').'>Administrador</option>
                <option value="user" '.($rol=='user'?'selected':'').'>Usuario</option>
                <option value="moderator" '.($rol=='moderator'?'selected':'').'>Moderador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="enviar">Guardar cambios</button>
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