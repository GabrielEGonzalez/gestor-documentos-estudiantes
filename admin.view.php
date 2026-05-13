<?php
require_once './config/bd.php';
session_start();

if (isset($_SESSION['usuario_id'])) {
    $resul = $conn->query("SELECT
    u.nombre,
    u.correo,
    a.nombre_original,
    a.guardado,
    DATE(a.fecha_subida) AS fecha_subida
    FROM usuarios AS u
    INNER JOIN archivos AS a ON a.usuario_id = u.id
    WHERE u.rol = 'estudiante';");

    $datosEstudiantes = $resul->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Profesor</title>

    <link rel="stylesheet" href="./css/panel.css">

    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto;
            background: #f5f7fb;
            margin: 0;
            color: #1f2937;
        }

        /* TOPBAR */

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 28px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo {
            width: 24px;
            height: 24px;
            stroke: #10b981;
            fill: none;
            stroke-width: 2;
        }

        .topbar h1 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .topbar input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            width: 240px;
        }

        /* LAYOUT */

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* TABLE CARD */

        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* HEADER */

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
        }

        .table-header h2 {
            font-size: 16px;
            margin: 0;
        }

        .count {
            font-size: 13px;
            color: #6b7280;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            font-size: 13px;
            color: #6b7280;
            padding: 14px 22px;
            border-bottom: 1px solid #eee;
        }

        td {
            padding: 16px 22px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        tr:hover {
            background: #f9fafb;
        }

        /* DOWNLOAD */

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            font-weight: 500;
            color: #2563eb;
        }

        .download-btn svg {
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .download-btn:hover {
            text-decoration: underline;
        }

        /* EMPTY */

        .empty {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }

        /* PANEL HEADER */

        .admin-header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(90deg, #1abc9c, #16a085);
            color: white;
        }

        .admin-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .admin-header p {
            opacity: .9;
        }

        /* DASHBOARD CARDS */

        .stats {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 25px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            width: 220px;
            text-align: center;
        }

        .card h3 {
            font-size: 1.8rem;
            color: #1abc9c;
        }

        .card p {
            color: #777;
        }

        /* SEARCH */

        .search-box {
            text-align: center;
            margin: 20px;
        }

        .search-box input {
            padding: 10px 14px;
            width: 320px;
            max-width: 90%;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* TABLE */

        .admin-table {
            width: 95%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
        }

        .admin-table thead {
            background: #1abc9c;
            color: white;
        }

        .admin-table th,
        .admin-table td {
            padding: 14px;
            text-align: center;
        }

        .admin-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: .2s;
        }

        .admin-table tbody tr:hover {
            background: #f6fffd;
        }

        /* BUTTON */

        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 6px;
            background: #3498db;
            color: white;
            text-decoration: none;
            font-size: .9rem;
            transition: .2s;
        }

        .btn-download:hover {
            background: #217dbb;
            transform: scale(1.05);
        }

        /* EMPTY */

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        /* RESPONSIVE */

        @media(max-width:700px) {

            .admin-table {
                font-size: .9rem;
            }

        }
    </style>

</head>

<body>

    <header class="topbar">

        <div class="topbar-left">

            <svg class="logo" viewBox="0 0 24 24">
                <path d="M4 4h16v16H4z" />
            </svg>

            <h1>Panel del Profesor</h1>

        </div>

        <div class="topbar-right">

            <input type="text" id="buscador" placeholder="Buscar estudiante...">

        </div>

    </header>


    <!-- STATS -->

    <div class="stats">

        <div class="card">
            <h3><?php echo isset($datosEstudiantes) ? count($datosEstudiantes) : 0; ?></h3>
            <p>Documentos</p>
        </div>

        <div class="card">
            <h3>👨‍🎓</h3>
            <p>Estudiantes</p>
        </div>

        <div class="card">
            <h3>📄</h3>
            <p>Archivos enviados</p>
        </div>

    </div>


    <!-- BUSCADOR -->

    <div class="search-box">
        <input type="text" id="buscador" placeholder="Buscar estudiante o documento...">
    </div>


    <main class="container">

        <div class="table-card">

            <div class="table-header">

                <h2>Documentos enviados</h2>

                <span class="count">
                    <?= isset($datosEstudiantes) ? count($datosEstudiantes) : 0 ?> registros
                </span>

            </div>

            <table>

                <thead>
                    <tr>

                        <th>Estudiante</th>
                        <th>Correo</th>
                        <th>Documento</th>
                        <th>Fecha</th>

                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($datosEstudiantes)): ?>

                        <?php foreach ($datosEstudiantes as $estudiante): ?>

                            <tr>

                                <td class="student">
                                    <?= htmlspecialchars($estudiante['nombre']) ?>
                                </td>

                                <td class="email">
                                    <?= htmlspecialchars($estudiante['correo']) ?>
                                </td>

                                <td>

                                    <a class="download-btn" href="<?= htmlspecialchars($estudiante['guardado']) ?>">

                                        <svg viewBox="0 0 24 24" width="16">
                                            <path d="M12 3v12m0 0l4-4m-4 4l-4-4" />
                                            <path d="M5 19h14" />
                                        </svg>

                                        <?= htmlspecialchars($estudiante['nombre_original']) ?>

                                    </a>

                                </td>

                                <td class="date">
                                    <?= htmlspecialchars($estudiante['fecha_subida']) ?>
                                </td>

                            </tr>

                        <?php endforeach ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="4" class="empty">
                                No hay documentos disponibles
                            </td>
                        </tr>

                    <?php endif ?>

                </tbody>

            </table>

        </div>

    </main>

    <script>

        /* BUSCADOR */

        document.getElementById("buscador").addEventListener("keyup", function () {

            let filter = this.value.toLowerCase()

            let rows = document.querySelectorAll("tbody tr")

            rows.forEach(row => {

                let text = row.innerText.toLowerCase()

                row.style.display = text.includes(filter) ? "" : "none"

            })

        })


        /* ORDENAR COLUMNAS */

        document.querySelectorAll("th").forEach((th, index) => {

            th.style.cursor = "pointer"

            th.addEventListener("click", () => {

                let rows = Array.from(document.querySelectorAll("tbody tr"))

                let asc = th.classList.toggle("asc")

                rows.sort((a, b) => {

                    let tdA = a.children[index].innerText.toLowerCase()

                    let tdB = b.children[index].innerText.toLowerCase()

                    return asc ? tdA.localeCompare(tdB) : tdB.localeCompare(tdA)

                })

                rows.forEach(row => document.querySelector("tbody").appendChild(row))

            })

        })

    </script>

</body>

</html>