<?php
//crear la session
session_start();
require_once('./config/bd.php');
global $conn;
//consultar a la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['correo']) ?? null;
    $pass = isset($_POST['password']) ?? null;
    $sql = 'select id, correo , pass , rol from usuarios where correo = ' . $correo;
    $user = $conn->query($sql)->fetch_assoc();
    $conn->close();
    if (isset($user['correo'])) {
        //validamos las credenciales
        if (password_verify($pass, $user['pass'])) {
            //crear la session
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['usuario_id'] = $user['id'];
            //redirecion por rol
            if ($user['rol'] === 'estudiante') {
                header('location : dashboard.view.php');
            } else {
                header('location : admin.view.php');
            }
        }
    }
    //redirecionar a los vistas
    header('location : register.view.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/" method="post">
        <label for="correo">Correo:</label>
        <input type="email" name="correo">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
    </form>
</body>

</html>