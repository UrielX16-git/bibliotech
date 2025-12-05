<?php
$host = "localhost";
$dbname = "bibliotech";
$username = "root";
$password = "161202";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

return $mysqli;
?>