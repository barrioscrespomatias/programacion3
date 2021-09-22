<?php

// include_once __DIR__ . './backend/validarSesion.php';
require_once __DIR__ . './backend/interfaces.php';
include_once __DIR__ . './backend/fabrica.php';
include_once __DIR__ . './backend/entidades/empleado.php';

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno


$fabrica = new Fabrica('La fábrica');
$fabrica->TraerDeArchivo('./backend/archivos/empleados.txt');




// echo $fabrica->ToString();
?>
<!-- <a href="./backend/cerrarSesion.php">Cerrar sesión</a> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- init bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    
    <!-- card css -->
    <!-- <link rel="stylesheet" link href="./frontend/css/card.css"> -->
    <!-- custom css -->
    <link rel="stylesheet" link href="./frontend/css/styles.css">
    <title>Document</title>
</head>

<body>

    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Registrate</a>
                </li>               
                <li class="nav-item">
                <a class="nav-link" href="#">Nosotros</a>
                </li>               
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="escribí tu búsqueda..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            </div>
        </div>
    </nav>

    </header>

    <div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Lista de empleados</h1>
        <p class="lead">Personajes de looney toones que han trabajado en nuestra empresa.</p>
    </div>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($fabrica->GetEmpleados() as $empleado) : ?>
                <div class="col-sm-6 col-md-4 d-flex justify-content-around">
                    <div class="card mt-5 mb-5" style="width: 200px; height: 400px">
                        <img src="./backend/<?php echo $empleado->GetPathFoto(); ?>" alt="..." width="100%" height="100%">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo  $empleado->GetApellido() . '-' . $empleado->GetNombre(); ?></h5>
                            <p class="card-text"><?php echo 'Sueldo $'. $empleado->GetSueldo(); ?></p>
                            <a href="#" class="btn btn-primary">Ver más info</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>