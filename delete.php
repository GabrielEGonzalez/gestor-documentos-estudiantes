<?php
    require_once './config/bd.php';

    $id = $_GET['id'];

    $stmt = $conn->prepare('SELECT guardado FROM archivos where id = ?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $resul = $stmt->get_result();
    $stmt->close();
    $ruta = $resul->fetch_assoc();

    if(file_exists($ruta)){
        if(unlink($ruta)){
            echo 'archivo eliminado';
        }else{
            echo 'archivo no fue eliminado';
        }
    }

    $stmt = $conn->prepare('DELETE FROM archivos where id = ?');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();

    echo 'archivo eliminado';
    header('location: panel.view.php');

?>