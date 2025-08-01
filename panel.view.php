<?php
    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header('location: register.view.php');
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