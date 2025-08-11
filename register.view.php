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
            "nombre"=>$_POST['nombre'],
            "correo"=>$_POST['correo'],
            "pass"=>$_POST['pass'],
            "rol"=>$rol
        ];
        //insertar los datos en la base de datos
        $pass = password_hash($userdata['pass'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios(nombre,correo,pass,rol) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss',$userdata['nombre'],$userdata['correo'],$pass,$userdata['rol']);
        $stmt->execute();
        $stmt->close();

        $sql = 'SELECT id FROM usuarios WHERE correo = ?';
        $stmt =$conn->prepare($sql);
        $stmt->bind_param('s', $userdata['correo']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        //crear la session con usario_id , rol
        $_SESSION['rol'] = $userdata['rol'];
        $_SESSION['usuario_id'] = $row ? $row['id'] : null;
        //redireccion

        header('location: panel.view.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="./css/formulario.css">
</head>
<body>

    <div class="contenedor">
        <div class="imagen">
        <img src="./img/freepik__the-style-is-candid-image-photography-with-natural__2573.png" alt="">
        </div>

        <form action="" method="post">
            <div class="text">
            <h1>Crea tu cuenta</h1>
            </div>
            <p>Únete a nuestra comunidad para acceder a tus tareas.</p>

            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan Pérez" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" id="correo" placeholder="ejemplo@correo.com" required>

            <label for="pass">Contraseña:</label>
            <input type="password" name="pass" id="pass" placeholder="Crea tu contraseña segura" required>

            <input style="margin-top:30px;" type="submit" value="Registrarme">
            <div class="text" style="text-aling:left;" >
            <p>¿Ya tienes una cuenta? <a href="login.view.php">Inicia sesión aquí.</a></p>
            </div>
        </form>
    </form>
    </div>
</body>
</html>