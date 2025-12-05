<?php
$mysqli = require __DIR__ . "/database.php";

$email = "admin@bibliotech.com";
$password = "admin123";
$nombre = "Administrador";

// Check if admin exists
$check_sql = sprintf("SELECT id FROM logindb WHERE email = '%s'", $mysqli->real_escape_string($email));
$result = $mysqli->query($check_sql);

if ($result->num_rows == 0) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO logindb (nombre, email, password_hash, role) VALUES (?, ?, ?, 'admin')";
    
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare($sql)) {
        $stmt->bind_param("sss", $nombre, $email, $password_hash);
        if ($stmt->execute()) {
            echo "Usuario administrador creado exitosamente.<br>";
            echo "Email: $email<br>";
            echo "Password: $password<br>";
        } else {
            echo "Error creando administrador: " . $stmt->error;
        }
    } else {
        echo "Error preparando consulta: " . $mysqli->error;
    }
} else {
    echo "El usuario administrador ya existe.";
}
?>
