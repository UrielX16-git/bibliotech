<?php
session_start();

if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Acceso denegado']);
    exit;
}

if (isset($_POST['id'])) {
    $mysqli = require __DIR__ . "/../database.php";
    $id = $mysqli->real_escape_string($_POST['id']);
    $sql = "UPDATE papers SET Borrado = 1 WHERE ID = $id";
    if ($mysqli->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Paper eliminado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar: ' . $mysqli->error]);
    }
    $mysqli->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
}
?>