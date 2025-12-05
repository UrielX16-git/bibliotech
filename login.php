<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: .");
    exit;
}

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";
    $email = $mysqli->real_escape_string($_POST["email"]);
    $sql = sprintf("SELECT * FROM logindb WHERE email = '%s'", $email);
    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user["password_hash"])) {



        session_regenerate_id();

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_role"] = $user["role"];

        // Bitacora Login
        $fecha = date("Y-m-d H:i:s");
        $mysqli->query("INSERT INTO acceso (usuario_id, fecha, login) VALUES ({$user['id']}, '$fecha', 1)");

        header("Location: .");
        exit;
    }

    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Bibliotech</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <link rel="icon" href="archivos/img/icon.png" type="image/png">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href=".">
            <img src="archivos/img/icon.png" width="30" height="30" class="d-inline-block align-top" alt=""
                loading="lazy" style="margin-right: 10px; background-color: white;">
            Bibliotech
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-success my-2 my-sm-0" href="signup.php">Registrate</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Iniciar Sesión</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($is_invalid): ?>
                            <div class="alert alert-danger" role="alert">
                                Error al iniciar sesión. Verifica tus credenciales.
                            </div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>