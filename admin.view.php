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
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="./css/panel.css">
</head>
<body>
    <header style="text-align: center; display:flex; flex-direction:column;">
        <div>
            <h1>Panel de Gestión del Profesor</h1><br>
        </div>
        <div>
            <p>Desde este panel puede supervisar y gestionar todos los documentos enviados por los estudiantes. <br> 
            Puede realizar búsquedas, descargar archivos, revisar fechas de entrega y eliminar archivos si es necesario.</p>
        </div>
    </header>

    <!-- 🔹 Buscador -->
    <div style="margin:20px; text-align:center;">
        <input type="text" id="buscador" placeholder="Buscar estudiante..."
        style="padding:8px; width:300px; border-radius:6px; border:1px solid #ccc;">
    </div>

    <!-- 🔹 Contador -->
    <h3 style="text-align:center; margin:10px;">
        Total de documentos: <?php echo isset($datosEstudiantes) ? count($datosEstudiantes) : 0; ?>
    </h3>

    <main class="con">
        <table>
            <thead>
                <tr>
                    <th>Nombre Estudiante</th>
                    <th>Correo Electrónico</th>
                    <th>Descargar Documentos</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($datosEstudiantes)): ?>
                    <?php foreach ($datosEstudiantes as $estudiante): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($estudiante['nombre'])?></td>
                        <td><?php echo htmlspecialchars($estudiante['correo'])?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($estudiante['guardado'])?>">
                                <?php echo htmlspecialchars($estudiante['nombre_original'])?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($estudiante['fecha_subida'])?></td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No hay documentos disponibles</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </main>

    <!-- 🔹 Scripts -->
    <script>
        // Filtro rápido
        let rows = document.querySelectorAll("tbody tr");
        console.log(rows);
        document.getElementById("buscador").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");
            
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });

        // Ordenar columnas al hacer clic
        document.querySelectorAll("th").forEach((th, index) => {
            th.style.cursor = "pointer";
            th.addEventListener("click", () => {
                let rows = Array.from(document.querySelectorAll("tbody tr"));
                let asc = th.classList.toggle("asc");

                rows.sort((a, b) => {
                    let tdA = a.children[index].innerText.toLowerCase();
                    let tdB = b.children[index].innerText.toLowerCase();
                    return asc ? tdA.localeCompare(tdB) : tdB.localeCompare(tdA);
                });

                rows.forEach(row => document.querySelector("tbody").appendChild(row));
            });
        });
    </script>
</body>
</html>
