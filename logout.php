<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    // Bitacora Logout
    $fecha = date("Y-m-d H:i:s");
    $mysqli->query("INSERT INTO acceso (usuario_id, fecha, login) VALUES ({$_SESSION['user_id']}, '$fecha', 0)");
}

session_destroy();

header("Location: index.php");
exit;
?>