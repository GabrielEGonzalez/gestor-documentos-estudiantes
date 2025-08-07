<?php
        require_once './config/bd.php';
        session_start();
        
        if(isset($_SESSION['usuario_id'])){
            $resul = $conn->query("SELECT
            u.nombre,
            u.correo,
            a.nombre_original,
            a.guardado,
            a.fecha_subida
            FROM
            usuarios AS u
            INNER JOIN
            archivos AS a ON a.usuario_id = u.id
            WHERE
            u.rol = 'Estudiantes';");
            $datosEstudiantes = $resul->fetch_all(MYSQLI_ASSOC);
        }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>panel admin</title>
</head>
<body>
    
</body>
</html>