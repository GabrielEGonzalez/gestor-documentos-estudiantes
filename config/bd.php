<?php

    $localhost ="";
    $username = "";
    $password = "";
    $bd_name="";

    $conn = new  mysqli($localhost, $username, $password, $bd_name);

    if($conn->connect_error){
        die("Error de conexion");
    }
?>