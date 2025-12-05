<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $mysqli = require __DIR__ . "/../database.php";

    $id = $mysqli->real_escape_string($_GET['id']);
    $userId = $_SESSION['user_id'];

    $sql = "SELECT Archivo FROM papers WHERE ID = $id";
    $result = $mysqli->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $archivo = $row['Archivo'];

        // Registrar
        $fecha = date("Y-m-d H:i:s");
        $logSql = "INSERT INTO descargas (paper_id, usuario_id, fecha) VALUES ($id, $userId, '$fecha')";
        $mysqli->query($logSql);
        // Descargar
        if (file_exists($archivo)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            readfile($archivo);
            exit;
        } else {
            echo "El archivo no existe en el servidor.";
        }
    } else {
        echo "Paper no encontrado.";
    }

    $mysqli->close();
} else {
    echo "Acceso denegado o ID no válido.";
}
?>