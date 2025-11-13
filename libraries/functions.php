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
        catch (PDOException $p) {
            echo "Error ".$p->getMessage()."<br />";
        }
    }

    function insertBD($data) {
        $bd = connBD();

        return ($bd -> query("INSERT INTO usuarios(nombre, email, rol) VALUES ('".$data['usuario']."','".$data['email']."','".$data['rol']."')"));
    }

    // function crearNuevaBD() {

    // }

    function showBD() {
        $bd = connBD();

        //dump("SELECT * FROM `usuarios`");

        return ($bd -> query("SELECT * FROM usuarios"));
    }

    function deleteUser($id) {
        $bd = connBD();

        try {
            $sth = $bd -> prepare("DELETE FROM `usuarios` WHERE `usuarios`.`id` = $id");
            return $sth -> execute();
        }
        catch (PDOException $p){
            return false;
        }
        
    }


?>