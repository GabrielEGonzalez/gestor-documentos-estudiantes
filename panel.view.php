<?php
session_start();

require_once './config/bd.php';
if (!isset($_SESSION['usuario_id'])) {
    header('location: register.view.php');
}

$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

$stmt = $conn->prepare('SELECT * FROM archivos WHERE usuario_id = ?');
$stmt->bind_param('i', $_SESSION['usuario_id']);
$stmt->execute();
$resul = $stmt->get_result();
$stmt->close();
$archivos = $resul->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>

    <style>
        table {
            border-collapse: collapse;
            border: 2px solid #000;
        }

        td , th {
            border: 1px solid black;
            padding:10px;
            text-align:center;
        }
    </style>
</head>

<body>
    
    <?php if (!empty($mensaje)): ?>
    <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-bottom: 10px;">
        <?= $mensaje ?>
    </div>
<?php endif; ?>
    <form action="uploads.php" method="post" enctype="multipart/form-data">
        <label for="envio">envio de documento:</label>
        <input type="file" name="envio" id="envio"><br>
        <h6>documentos con extencion .pdf .doc .docx</h6>
        <input type="submit" value="Enviar" onclick="startProgress()">
    </form>

    <main class="con">
        <h2>Lista de documentos</h2>
        <table style="border:1px solid black;">
            <thead>
                <tr>
                    <th style="border:1px solid black;">nombre archivo</th>
                    <th style="border:1px solid black;">fecha archivo</th>
                    <th style="border:1px solid black;">Descargar archivo</th>
                    <th style="border:1px solid black;">eliminar archivos</th>
                </tr>


            </thead>
            <tbody>
                <?php foreach ($archivos as $ar):
                    ; ?>
                    <tr>
                        <td> <?php echo $ar['nombre_original']; ?></td>
                        <td> <?php echo $ar['fecha_subida']; ?></td>
                        <td> <a href="<?php echo $ar['guardado']; ?>">Descargar</a></td>
                        <td> <a href="<?php echo './delete.php?id=' . $ar['id']; ?>">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </main>

    <script>
        let poss = 0;
        let possgress = document.getElementById('myProgressBar');

        function startProgress() {
            const interval = setInterval(function () {
                poss += 1;
                possgress.value = poss;
                if (poss >= 1000) {
                    clearInterval(interval);
                }
            }, 9);
        }
    </script>
</body>

</html>