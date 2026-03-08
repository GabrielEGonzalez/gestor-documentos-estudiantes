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
    <link rel="stylesheet" href="./css/panel.css">
    <style>
        /* RESET */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", "Segoe UI", sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f4f7fb;
            color: #333;
        }

        /* HEADER */

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            background: linear-gradient(90deg, #1abc9c, #16a085);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 1.6rem;
            font-weight: 600;
        }

        nav ul {
            display: flex;
            gap: 20px;
        }

        nav li {
            list-style: none;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            opacity: .9;
            transition: .2s;
        }

        header a:hover {
            opacity: 1;
        }

        /* FORM UPLOAD */

        form {
            margin: 30px auto;
            background: white;
            width: 520px;
            max-width: 90%;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        .upload-box {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .upload-box label {
            font-weight: 600;
            font-size: 1.1rem;
        }

        form input[type=file] {
            padding: 15px;
            border: 2px dashed #dcdcdc;
            border-radius: 8px;
            background: #fafafa;
            cursor: pointer;
        }

        form input[type=submit] {
            margin-top: 10px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #1abc9c;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: .2s;
        }

        form input[type=submit]:hover {
            background: #16a085;
            transform: scale(1.02);
        }

        .help {
            font-size: .85rem;
            color: #777;
        }

        /* ALERT */

        .alert {
            background: #d4edda;
            padding: 12px;
            border-radius: 8px;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        /* MAIN */

        .con {
            flex: 1;
            padding: 40px;
            max-width: 1200px;
            margin: auto;
            width: 100%;
        }

        .con h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* INFO BAR */

        .info-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 250px;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        thead {
            background: #1abc9c;
            color: white;
        }

        th,
        td {
            padding: 14px;
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: .2s;
        }

        tbody tr:hover {
            background: #f6fffd;
        }

        /* BUTTONS */

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            transition: .2s;
        }

        .download {
            background: #3498db;
            color: white;
        }

        .download:hover {
            background: #217dbb;
            transform: scale(1.05);
        }

        .delete {
            background: #e74c3c;
            color: white;
        }

        .delete:hover {
            background: #c0392b;
            transform: scale(1.05);
        }

        /* EMPTY STATE */

        .empty {
            padding: 40px;
            text-align: center;
            color: #777;
            font-size: 1.2rem;
        }

        /* FOOTER */

        footer {
            background: #222;
            color: #bbb;
            text-align: center;
            padding: 15px;
            margin-top: auto;
        }

        /* RESPONSIVE */

        @media (max-width:700px) {

            header {
                flex-direction: column;
                gap: 10px;
            }

            .info-bar {
                flex-direction: column;
                gap: 10px;
            }

            .search {
                width: 100%;
            }

            table {
                font-size: .9rem;
            }

        }
    </style>
</head>

<body>
    <header>
        <div class="titulo">
            <h1>Gestor de Documentos</h1>
        </div>

        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
        </nav>
    </header>


    <form action="uploads.php" method="post" enctype="multipart/form-data">
        <?php if (!empty($mensaje)): ?>
            <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-bottom: 10px;">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <div class="upload-box">
            <label for="envio">
                📂 Arrastra o selecciona un archivo
            </label>
            <input type="file" name="envio" id="envio">
            <p class="help">Archivos permitidos: PDF, DOC, DOCX</p>
            <input type="submit" value="Subir documento">
        </div>
    </form>

    <main class="con">
        <h2>Lista de documentos</h2>
        <div class="info-bar">
            <div>
                <strong>Total documentos:</strong> <?= count($archivos) ?>
            </div>
            <input type="text" class="search" placeholder="Buscar documento...">
        </div>
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
                <?php if (count($archivos) == 0): ?>
                    <td class="empty" colspan="4">
                        📂 No tienes documentos aún.<br>
                        Sube tu primer archivo arriba.
                    </td>
                <?php else: ?>
                    <?php foreach ($archivos as $key => $ar):
                        ; ?>
                        <?php $key = $key + 1; ?>
                        <?php $dato = $key % 2 == 0 ? "rgba(204, 204, 204, 0.84)" : "white" ?>
                        <tr style="background-color: <?php echo $dato ?>;">
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e74c3c"
                                    viewBox="0 0 16 16">
                                    <path d="M4 0h5l5 5v11H4z" />
                                </svg>
                                <?= $ar['nombre_original']; ?>
                            </td>
                            <td> <?php echo $ar['fecha_subida']; ?></td>
                            <td> <a href="<?php echo $ar['guardado']; ?>" class="btn download">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.1A1.5 1.5 0 0 0 2.5 14h11a1.5 1.5 0 0 0 1.5-1.5v-2.1a.5.5 0 0 1 1 0v2.1A2.5 2.5 0 0 1 13.5 15h-11A2.5 2.5 0 0 1 0 12.5v-2.1a.5.5 0 0 1 .5-.5z" />
                                        <path
                                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 1 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                    </svg>
                                    Descargar
                                </a></td>
                            <td> <a href="<?php echo './delete.php?id=' . $ar['id']; ?>" class="btn delete"
                                    onclick="return confirm('¿Seguro que quieres eliminar este archivo?');">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M5.5 5.5v7m5-7v7M2.5 3h11" />
                                        <path d="M6 2h4" />
                                        <path d="M3 3l1 11h8l1-11" />
                                    </svg>
                                    Eliminar
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php endif; ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2025 Mi Aplicación. Todos los derechos reservados.</p>
    </footer>
</body>

</html>