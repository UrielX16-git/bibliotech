<?php
$host = getenv('DB_HOST') ?: "db";
$dbname = getenv('DB_NAME') ?: "bibliotech";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "root";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

return $mysqli;
?>