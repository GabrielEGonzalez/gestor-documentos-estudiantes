<?php
//crear la session
session_start();
require_once('./config/bd.php');
global $conn;
//consultar a la base de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $pass = $_POST['password'];
    $sql = 'SELECT id, correo , pass , rol FROM usuarios WHERE correo = ? ';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s',$correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $conn->close();
    if (isset($user['correo'])) {
        //validamos las credenciales
        if (password_verify($pass, $user['pass'])) {
            //crear la session
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['usuario_id'] = $user['id'];
            //redirecion por rol
            if ($user['rol'] === 'estudiante') {
                header('Location : panel.view.php');
                exit();
            } else {
                header('Location : admin.view.php');
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
    <form action="" method="post">
        <label for="correo">Correo:</label>
        <input type="email" name="correo">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="enviar">
    </form>
</body>

</html>