<?php

    $localhost ="127.0.0.1:3307";
    $username = "root";
    $password = "";
    $bd_name="gestor_de_documentos";

    $conn = new  mysqli($localhost, $username, $password, $bd_name);

    if($conn->connect_error){
        die("Error de conexion");
    }
?>