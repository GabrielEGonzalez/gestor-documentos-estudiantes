<?php

    $localhost ="127.0.0.1:3306";
    $username = "root";
    $password = "";
    $bd_name="gestor";

    $conn = new mysqli($localhost, $username, $password, $bd_name);

    if($conn->connect_error){
        die("Error de conexion");
    }
?>