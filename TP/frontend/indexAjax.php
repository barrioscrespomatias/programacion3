<?php
session_start();

include_once __DIR__ . '/../backend/validarSesionAjax.php';
include_once '../backend/fabrica.php';

$dniEmpleadoModificar = isset($_POST['inputHidden']) ? $_POST['inputHidden'] : null;
$titulo = 'Barrios Crespo Matías';


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- init bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- animated js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="./css/styles.css">
    <title>TP-01 Lab-Prog III</title>

</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Backoffice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../backend/cerrarSesion.php">Cerrar Sesión</a>
                    </li>
                </ul>
                <!-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="escribí tu búsqueda..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form> -->
            </div>
        </div>
    </nav>
</header>

<body>
    <div class="row animate__animated animate__bounce">
        <h2 class="col-md-12 text-center"><?php echo $titulo; ?></h2>
        <div id="divFormlario" class="col-md-4 "></div>
        <div id="divTablaEmpleados" class="col-md-8"></div>
        <!-- <div id="divLinks" class="col-md-8">
            <a href="../index.php">
                <h2 class="m-3">Ir al listado</h2>
            </a>
            <a href="../backend/cerrarSesion.php">
                <h2 class="m-3">Cerrar Sesión</h2>
            </a>
        </div> -->
    </div>

    <!-- custom validations -->
    <script src="./javascript/validaciones/validaciones.js"></script>
    <!-- bootstrap javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>