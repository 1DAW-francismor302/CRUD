<?php
/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_error_handler("customError");

function dump($var){
  echo '<pre>'.print_r($var,1).'</pre>';
}

function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr";
}

function obtenerFecha(){
  $fechaAlta= date ("Y-m-d H:i:s");
  return $fechaAlta;
}

function obtenerUltimoID() {
  $file = 'users.csv';
  
  if (file_exists($file) && filesize($file) > 0) {
    $puntero = fopen($file, "r");
    
    $ultimoID = 1;
    
    while (($linea = fgetcsv($puntero)) !== FALSE) {
        $ultimoID = $linea[0]; 
    }
    
    fclose($puntero);
    
    return $ultimoID + 1;
  } else {
    return 1;
  }
}

$id = obtenerUltimoID();
$fechaAlta = obtenerFecha();

function leerPost($id, $fechaAlta){

  if (!empty($_POST)){
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    if (($archivo = fopen("users.csv", 'a+')) !== FALSE) {
      fwrite($archivo, $id.','.$usuario.','.$email.','.$rol.','.$fechaAlta."\n");
    }
  }
      
}

function getFormularioMarkup($id, $fechaAlta) {
    $output = '<form action="'.leerPost($id, $fechaAlta).'" method="post">
    <div class="form-group">
        <label for="exampleInputusername">Nombre de Usuario</label>
        <input type="text" name="usuario" class="form-control" id="exampleInputusername" placeholder="Enter username" required/>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required/>
    </div>
    <div class="form-group">
        <label for="roleSelect">Rol</label>
        <select id="roleSelect" name="rol" class="form-control">
        <option value="admin">Administrador</option>
        <option value="user">Usuario</option>
        <option value="moderator">Moderador</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <br>
    <button class="btn index"><a href="index.php">Volver al índice</a></button>';

    
    return $output;
}

$formularioMarkup = getFormularioMarkup($id, $fechaAlta);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Formulario Estético</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
    input[type="password"],
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

    .form-text {
      font-size: 0.8rem;
      color: #666;
      margin-top: 0.3rem;
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
  </style>
</head>
<body>
  <div>
    <?php echo $formularioMarkup; ?>
  </div>
</body>
</html>