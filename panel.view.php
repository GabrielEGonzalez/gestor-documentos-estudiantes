<?php

    require_once('./config/bd.php');

    $ruta = './uploads';

    if($_SERVER['REQUEST_METHOD']==="POST"){
        $filename= $ruta . basename($_FILES['envio']['name']);

    if($_FILES['envio']['size'] > 20000){
        $mensaje = '<div><h2>tamanio mayor 20mb.</h2></div>';
    }

    if(move_uploaded_file($_FILES['envio']['tmp_name'],$filename)){
        $mensaje = '<div><h2>archivo enviando exitosamente.</h2></div>';
    }
    }
    

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
</head>
<body>
    <form action="/" method="post" enctype="multipart/form-data">

    <label for="envio">envio de documento:</label>
    <input type="file" name="envio" id="envio"><br>
    <input type="submit" value="Enviar">
    </form>
</body>
</html>