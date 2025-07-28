<?php

require_once('./config/bd.php');

$ruta = './uploads';


//resivimos el archivo por el metodo post
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //se enruta a la carpeta de destino
    $filename = $ruta . basename($_FILES['envio']['name']);

    //se hace una verificacion del tamanio del archivo
    if ($_FILES['envio']['size'] < 10000) {
        $mensaje = '<div style=" background-color: rgba(194, 1, 1,0.5);color: #fff;width: 100%;height: 50px;"><h2>tamanio mayor 10mb.</h2></div>';
    }

    //verificamos las extenciones que recibimos por que solo aceptamos pdf
    if (pathinfo($_FILES['envio']['name'], PATHINFO_EXTENSION) == 'pdf') {
        $mensaje = '<div><h2>documentos con extencion no requerida</h2></div>';
    }

    //logica para recibir archivo
    if (file_exists($filename)) {
        $name = explode('.', $_FILES['envio']['name']);
        $nuevoname = $name[0] . "_" . $name[1];

        if (move_uploaded_file($_FILES['envio']['tmp_name'], $nuevoname)) {
            $mensaje = '<div style="background-color: rgba(1, 194, 33, 0.5);color: #fff;width: 100%;height: 50px;"><h2>archivo enviando exitosamente.</h2></div>';
        }

    } else {
        if (move_uploaded_file($_FILES['envio']['tmp_name'], $filename)) {
            $mensaje = '<div style="background-color: rgba(1, 194, 33, 0.5);color: #fff;width: 100%;height: 50px;"><h2>archivo enviando exitosamente.</h2></div>';
        }
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