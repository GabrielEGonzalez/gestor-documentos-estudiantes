<?php

require_once('./config/bd.php');

$ruta = './uploads';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $filename = $ruta . basename($_FILES['envio']['name']);

    if ($_FILES['envio']['size'] < 10000) {
        $mensaje = '<div style=" background-color: rgba(194, 1, 1,0.5);color: #fff;"><h2>tamanio mayor 10mb.</h2></div>';
    }

    if (pathinfo($_FILES['envio']['name'], PATHINFO_EXTENSION) == 'pdf') {
        $mensaje = '<div><h2>documentos con extencion no requerida</h2></div>';
    }

    if (move_uploaded_file($_FILES['envio']['tmp_name'], $filename)) {
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
    <?php echo $mensaje; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="envio">envio de documento:</label>
        <input type="file" name="envio" id="envio"><br>
        <h6>documentos con extencion .pdf .doc .docx</h6>
        <input type="submit" value="Enviar" onclick="startProgress()">
    </form>

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