<?php
        require_once './config/bd.php';
        session_start();
        
        if(isset($_SESSION['usuario_id'])){
            $resul = $conn->query("SELECT
            u.nombre,
            u.correo,
            a.nombre_original,
            a.guardado,
            DATE(a.fecha_subida) AS fecha_subida
            FROM
            usuarios AS u
            INNER JOIN
            archivos AS a ON a.usuario_id = u.id
            WHERE
            u.rol = 'estudiante';");
            $datosEstudiantes = $resul->fetch_all(MYSQLI_ASSOC);
            //print_r('<pre>');
            //print_r($datosEstudiantes);
            //print_r('</pre>');
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
    <header style="text-align: center;">
        <h1>Panel de Gestión del Profesor</h1>
        <p>Desde este panel puede supervisar y gestionar todos los documentos enviados por los estudiantes. <br> Puede realizar búsquedas, descargar archivos, revisar fechas de entrega y eliminar archivos si es necesario.</p>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Nombre Estudiante</th>
                    <th>Correo Electronico</th>
                    <th>Descargar Documentos</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($datosEstudiantes as $key => $estudiante):?>
                <tr>
                    <td><?php echo htmlspecialchars($estudiante['nombre'])?></td>
                    <td><?php echo htmlspecialchars($estudiante['correo'])?></td>
                    <td><a href="<?php echo htmlspecialchars($estudiante['guardado'])?>"><?php echo htmlspecialchars($estudiante['nombre_original'])?></a></td>
                    <td><?php echo htmlspecialchars($estudiante['fecha_subida'])?></td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </main>
</body>
</html>