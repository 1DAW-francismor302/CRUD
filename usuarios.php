<?php
/* Inicialización del entorno */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include_once('./libraries/functions.php');

function dump($var){
  echo '<pre>'.print_r($var,1).'</pre>';
}

function leerPost() {
    if (isset($_POST['cerrar_sesion'])) {
        unset($_SESSION['usuario']);
        header('Location: index.php');
    }
}

leerPost();

$usuarios = getUsuarios();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Índice de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
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

<h1>Usuarios</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha Registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        ?>
        <?php foreach ($usuarios as $usuario) : ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($usuario['rol'])); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($usuario['fecha_alta'])); ?></td>
                <td class='acciones'>
                    <form action='info.php' method='get'>
                        <input type='hidden' name='id' value=<?php echo $usuario['id'] ?>>
                        <button type='submit' class='btn btn-ver'>Ver Información</button>
                    </form>
                    
                     <form action='edit.php' method='get'>
                        <input type='hidden' name='id' value=<?php echo $usuario['id'] ?>>
                        <button type='submit' class='btn btn-borrar'>Editar Usuario</button>
                     </form>

                     <form action='delete.php' method='post'>
                        <input type='hidden' name='id' value=<?php echo $usuario['id'] ?>>
                        <button type='submit' class='btn btn-borrar'>Borrar Usuario</button>
                     </form>
                </td>
            </tr>
        <?php endforeach ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <button type="submit" class="btn" name="cerrar_sesion">Cerrar Sesión</button>
        </form>
    </tbody>
</table>
</body>
</html>
