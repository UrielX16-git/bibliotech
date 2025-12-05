<?php
session_start();

use Bibliotech\MyApi\Stats\Stats;

require_once __DIR__ . '/myapi/Stats/Stats.php';

header('Content-Type: application/json');

if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Acceso denegado']);
    exit;
}

$stats = new Stats('bibliotech');

$metric = $_GET['metric'] ?? '';

switch ($metric) {
    case 'tipo':
        echo json_encode($stats->obtenerDescargasPorTipo());
        break;
    case 'hora':
        echo json_encode($stats->obtenerDescargasPorHora());
        break;
    case 'top-papers':
        echo json_encode($stats->obtenerPapersMasDescargados());
        break;
    case 'top-users':
        echo json_encode($stats->obtenerUsuariosMasActivos());
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Métrica no válida']);
        break;
}
