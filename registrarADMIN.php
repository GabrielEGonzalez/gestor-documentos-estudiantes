<?php

    require_once './config/bd.php';

    $nombre= 'jhon Raul';
    $pass = password_hash('jhon',PASSWORD_DEFAULT);
    $correo = 'jhon@gmail.com';
    $rol = 'admin';
    $stmt = $conn->prepare('INSERT INTO usuarios(nombre,correo,pass,rol) VALUES(?,?,?,?)');
    $stmt->bind_param('ssss',$nombre,$correo,$pass,$rol);
    $stmt->execute();
    $stmt->close();

    echo 'usuario administrador creado!.';
?>