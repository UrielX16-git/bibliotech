<?php
session_start();

// Verificar login
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

// Verificar admin
if ($_SESSION["user_role"] !== 'admin') {
    die("ACCESO DENEGADO: No tienes permisos de administrador para ver esta página.");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Paper - Bibliotech</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../">
            <img src="../archivos/img/icon.png" width="30" height="30" class="d-inline-block align-top" alt=""
                loading="lazy" style="margin-right: 10px; background-color: white; border-radius: 50%;">
            Bibliotech
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-primary my-2 my-sm-0 mr-2" href="../index.php">Volver al inicio</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary my-2 my-sm-0" href="../logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Subir Nuevo Paper</h3>
                    </div>
                    <div class="card-body">
                        <form id="paper-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nombre">Nombre del Paper</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback" id="nombre-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="autores">Autores</label>
                                <input type="text" class="form-control" id="autores" name="autores" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha de Publicación</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="form-group">
                                <label for="explicacion">Explicación</label>
                                <textarea class="form-control" id="explicacion" name="explicacion" rows="3"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen de Portada</label>
                                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="paper">Documento PDF</label>
                                <input type="file" class="form-control-file" id="paper" name="paper"
                                    accept="application/pdf" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="submit-btn">Subir Paper</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#nombre').keyup(function () {
                let nombre = $(this).val();
                if (nombre) {
                    $.ajax({
                        url: '../backend/paper-check-name.php',
                        type: 'GET',
                        data: { nombre: nombre },
                        success: function (response) {
                            let data = JSON.parse(response);
                            let feedback = $('#nombre-feedback');
                            let input = $('#nombre');

                            if (data.status === 'error') {
                                input.addClass('is-invalid');
                                input.removeClass('is-valid');
                                feedback.text(data.message);
                                $('#submit-btn').prop('disabled', true);
                            } else {
                                input.addClass('is-valid');
                                input.removeClass('is-invalid');
                                feedback.text('');
                                $('#submit-btn').prop('disabled', false);
                            }
                        }
                    });
                }
            });

            $('#paper-form').submit(function (e) {
                e.preventDefault();

                let nombre = $('#nombre').val();
                let regex = /^[a-zA-Z0-9\s\-]+$/;
                if (!regex.test(nombre)) {
                    alert('El nombre solo puede contener letras, números, espacios y guiones.');
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: '../backend/paper-add.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        let data = JSON.parse(response);
                        if (data.status === 'success') {
                            alert(data.message);
                            $('#paper-form')[0].reset();
                            $('#nombre').removeClass('is-valid');
                        } else {
                            alert('Error: ' + data.message);
                        }
                    },
                    error: function () {
                        alert('Error en la comunicación con el servidor');
                    }
                });
            });
        });
    </script>
</body>

</html>