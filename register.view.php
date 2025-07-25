<?php
    require_once('./config/bd.php');
    global $conn;

    // crear la session
    session_start();
    //recibir el metodo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //recibir los datos del metodo post
        $rol = isset($_POST['rol'])? $_POST['rol']: 'estudiante';
        $userdata = [
            "nombre"=>isset($_POST['nombre']),
            "correo"=>isset($_POST['correo']),
            "pass"=>isset($_POST['pass']),
            "rol"=>$rol
        ];
        //insertar los datos en la base de datos
        $pass = password_hash($userdata['pass'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios(nombre,correo,pass,rol) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss',$userdata['nombre'],$userdata['correo'],$userdata['pass'],$userdata['rol']);

        $sql = 'SELECT id FROM usuarios WHERE correo ='. $userdata['correo'];
        $user_id = $conn->query($sql)->fetch_assoc();
        //crear la session con usario_id , rol
        $_SESSION['rol']=$userdata['rol'];
        $_SESSION['usuario_id']=$user_id;
        //redireccion

        header('location: panel.view.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo"><br>
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass">
        <br>
        <input type="submit" value="enviar">
    </form>
</body>
</html>