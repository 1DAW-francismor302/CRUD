<?php

    function connBD() {
        // $host = 'localhost';
        // $username = 'root';
        // $pswd = 'crud_mysql';
        // $db = 'crud_mysql';
        // $csvFile = './data/users.csv';

        try {
            $conectar = new PDO ('mysql:host=localhost;dbname=crud_mysql','crud_mysql','crud_mysql');
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conectar;
        }
        catch (Exception $e) {
            return null;
        }
    }

    function insertBD($data) {
        $bd = connBD();

        try{
            $sth = $bd -> prepare("INSERT INTO usuarios(nombre, email, rol) VALUES ('".$data['usuario']."','".$data['email']."','".$data['rol']."')");
            return $sth->execute();
        }catch (Exception $e) {
            return null;
        }
    }

    function reiniciarBD() {
        $bd = connBD();
        try{        
            $bd-> exec("DROP TABLE IF EXISTS usuarios");
            return $bd->exec("CREATE TABLE `crud_mysql`.`usuarios` (`id` INT(3) NOT NULL AUTO_INCREMENT, `nombre` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `rol` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `fecha_alta` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = InnoDB;");
        }catch(Exception $e){
            return false;
        }
    }

    function getUsuarios() {
        $bd = connBD();

        try{
            $sth = $bd-> prepare("SELECT * FROM usuarios");
            $sth->execute();
            $resultado = $sth->fetchAll();
            return $resultado;
        }catch (Exception $e) {
            return false;
        }
    }

    function deleteUser($id) {
        $bd = connBD();

        try {
            $sth = $bd -> prepare("DELETE FROM `usuarios` WHERE `usuarios`.`id` = $id");
            return $sth -> execute();
        }
        catch (Exception $e){
            return false;
        }
        
    }

    // function showUser($id) {
    //     $bd = connBD();

    //     return ($bd -> query("SELECT `nombre`, `email`, `rol` FROM `usuarios` WHERE `id` = $id"));
    // }

    function updateUser($id, $nuevosDatos) {
        $bd = connBD();

        try{
            $sth = $bd -> prepare("UPDATE usuarios SET nombre = '" . $nuevosDatos['nombre'] . "', email = '" . $nuevosDatos['email'] . "', rol = '" . $nuevosDatos['rol'] . "' WHERE id = '" . $id . "'");
            return $sth->execute();
        }catch (Exception $e) {
            return false;
        }
    }


?>