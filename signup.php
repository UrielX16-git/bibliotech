<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $nombre = $mysqli->real_escape_string($_POST["nombre"]);
    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    if ($password !== $password_confirmation) {
        $error_message = "Las contraseñas no coinciden";
    } else {
        // Verificar email
        $check_sql = sprintf("SELECT id FROM logindb WHERE email = '%s'", $email);
        $result = $mysqli->query($check_sql);

        if ($result->num_rows > 0) {
            $error_message = "El email ya está registrado";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO logindb (nombre, email, password_hash, role) VALUES (?, ?, ?, 'cliente')";

            $stmt = $mysqli->stmt_init();

            if (!$stmt->prepare($sql)) {
                die("Error SQL: " . $mysqli->error);
            }

            $stmt->bind_param("sss", $nombre, $email, $password_hash);

            if ($stmt->execute()) {
                $success_message = "Cuenta creada exitosamente. Ahora puedes iniciar sesión.";
            } else {
                if ($mysqli->errno === 1062) {
                    $error_message = "El email ya está registrado";
                } else {
                    die($mysqli->error . " " . $mysqli->errno);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Bibliotech</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <link rel="icon" href="archivos/img/icon.png" type="image/png">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="archivos/img/icon.png" width="30" height="30" class="d-inline-block align-top" alt=""
                loading="lazy" style="margin-right: 10px; background-color: white;">
            Bibliotech
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary my-2 my-sm-0" href="login.php">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Crear Cuenta</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($error_message) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success_message): ?>
                            <div class="alert alert-success" role="alert">
                                <?= htmlspecialchars($success_message) ?>
                                <br>
                                <a href="login.php" class="alert-link">Ir a Iniciar Sesión</a>
                            </div>
                        <?php else: ?>
                            <form method="post">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                        value="<?= htmlspecialchars($_POST["nombre"] ?? "") ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" required>
                                </div>

                                <button type="submit" class="btn btn-success btn-block">Registrarse</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>