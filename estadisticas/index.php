<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estadísticas - Bibliotech</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <link rel="icon" href="../archivos/img/icon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../">
            <img src="../archivos/img/icon.png" width="30" height="30" class="d-inline-block align-top" alt=""
                loading="lazy" style="margin-right: 10px; background-color: white;">
            Bibliotech
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary my-2 my-sm-0 mr-2" href="../">Volver al inicio</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary my-2 my-sm-0" href="../logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Panel de Estadísticas</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Descargas por Tipo de Recurso</div>
                    <div class="card-body">
                        <canvas id="chartTipo"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Descargas por Hora del Día</div>
                    <div class="card-body">
                        <canvas id="chartHora"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Top 5 Papers Más Descargados</div>
                    <div class="card-body">
                        <canvas id="chartTopPapers"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Top 5 Usuarios Más Activos</div>
                    <div class="card-body">
                        <canvas id="chartTopUsers"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="app.js"></script>
</body>

</html>