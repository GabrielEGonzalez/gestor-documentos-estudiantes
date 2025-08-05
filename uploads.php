<?php
    session_start();
require_once('./config/bd.php');

$ruta = 'uploads/';


//resivimos el archivo por el metodo post
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //se enruta a la carpeta de destino
    $filename = $ruta . basename($_FILES['envio']['name']);

    //se hace una verificacion del tamanio del archivo
    if ($_FILES['envio']['size'] < 10000) {
        $mensaje = '<div style=" background-color: rgba(194, 1, 1,0.5);color: #fff;width: 100%;height: 50px;"><h2>tamanio mayor 10mb.</h2></div>';
        $_SESSION['mensaje'] = $mensaje;
    }

    //verificamos las extenciones que recibimos por que solo aceptamos pdf
    if (pathinfo($_FILES['envio']['name'], PATHINFO_EXTENSION) == 'pdf') {
        $mensaje = '<div><h2>documentos con extencion no requerida</h2></div>';
        $_SESSION['mensaje'] = $mensaje;
    }

    //logica para recibir archivo
    if (file_exists($filename)) {
        $name = explode('.', $_FILES['envio']['name']);
        $nuevoname = $ruta . $name[0] . "_" . $name[1];

        if (move_uploaded_file($_FILES['envio']['tmp_name'], $nuevoname)) {
            $mensaje = '<div style="background-color: rgba(1, 194, 33, 0.5);color: #fff;width: 100%;height: 50px;"><h2>archivo enviando exitosamente.</h2></div>';
            $fecha = new DateTime('now',new DateTimeZone('America/Panama'));
            $fecha1 = $fecha->format('Y-m-d');
            $stmt = $conn->prepare('INSERT INTO archivos(nombre_original,guardado,usuario_id) values(?,?,?);');
            $stmt->bind_param('sss',$_FILES['envio']['name'],$nuevoname,$_SESSION['usuario_id']);
            $stmt->execute();
            $stmt->close();
            $_SESSION['mensaje'] = $mensaje;
            header('location: panel.view.php');
        }

    } else {
        if (move_uploaded_file($_FILES['envio']['tmp_name'], $filename)) {
            $mensaje = '<h2>archivo enviando exitosamente.</h2>';
            $stmt = $conn->prepare('INSERT INTO archivos(nombre_original,guardado,usuario_id) values(?,?,?);');
            $stmt->bind_param('sss',$_FILES['envio']['name'],$filename,$_SESSION['usuario_id']);
            $stmt->execute();
            $stmt->close();

            $_SESSION['mensaje'] = $mensaje;

            header('location: panel.view.php');
        }
    }

}

?>