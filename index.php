<?php

include_once('./libraries/functions.php');

/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

function dump($var){
  echo '<pre>'.print_r($var,1).'</pre>';
}

function getLogInMarkup($mensajeError){
    $output = '
    <div class="card">
        '.(!empty($mensajeError) ? '<div class="error">'.$mensajeError.'</div>' : '').'
        <h2>Iniciar Sesión</h2>
        <form action="'.$_SERVER["PHP_SELF"].'" method="post">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="Introduce tu email">
            <br><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" placeholder="Introduce tu contraseña">
            <br>

            <button type="submit" name="iniciar_sesion" class="btn">Iniciar Sesión</button>
            
            <div class="div">
                <p>¿No tienes cuenta?</p>
                <button type="submit" name="registrarse" class="btn">Registrarse</button>
            </div>
        </form>
    </div>';

    return $output;
}

$usuariosData = getUsuarios();

function leerPost($usuariosData) {
    $mensajeError = "";
    if (isset($_POST['iniciar_sesion'])){
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $contrasena = $_POST['password'];
        } else {
            $mensajeError = "No se ha introducido un email o contraseña.";
            return $mensajeError;
        }
        foreach ($usuariosData as $usuario) {
            if ($usuario['email'] === $email && $usuario['password'] === $contrasena) {
                $_SESSION['usuario'] = $usuario;
                header('Location: usuarios.php');
                exit;
            }
        }
        $mensajeError = "El usuario/contraseña introducidos no son correctos";
    }elseif (isset($_POST['registrarse'])) {
        header('Location: create.php');
    }

    return $mensajeError;
}

$mensajeError = leerPost($usuariosData);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
   
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

        .div {
            display: flex;
            flex-direction: row;
            align-items: baseline;
            justify-content: center;
            gap: 10px;
        }

        label {
            font-weight: bold;
            color: #3f51b5;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 1rem;
            box-sizing: border-box;
            font-size: 14px;
        }

        .error {
            background-color: #ffdddd;
            color: red;
            border: 1px solid red;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>
    <?php
        echo getLogInMarkup($mensajeError); 
    ?>
</body>
</html>