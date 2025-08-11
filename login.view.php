<?php
//crear la session
require_once('./config/bd.php');
session_start();
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
    $stmt->close();
    $user = $result->fetch_assoc();

    if (isset($user['correo'])) {
        //validamos las credenciales
        if (password_verify($pass, $user['pass'])) {
            //crear la session
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['usuario_id'] = $user['id'];
            //redirecion por rol
            if ($user['rol'] === 'estudiante') {
                header('Location: panel.view.php');
                exit();
            } else {
                header('Location: admin.view.php');
                exit();
            }
        }
    }
    //redirecionar a los vistas
    header('location: register.view.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/formulario.css">
</head>

<body>

    <div class="contenedor">
        <div class="imagen">
        <img src="./img/freepik__the-style-is-candid-image-photography-with-natural__2573.png" alt="">
        </div>

        <form action="" method="post">
        <div class="text">
            <h1>Iniciar Sesión</h1>
        </div>
        <p>¡Bienvenido de nuevo! <br> Por favor, ingresa tus datos.</p>
        <label for="correo">Correo:</label>
        <input type="email" name="correo">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password"><br>
        <a href="#">¿Olvidaste tu contraseña?</a><br>
        <input type="submit" value="enviar">
        <div class="text">
            <p>¿No tienes una cuenta? <a href="#">Regístrate aquí.</a></p>
        </div>
        </form>
    </div>
    
</body>

</html>