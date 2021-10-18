<?php

include_once __DIR__ . '/backend/validarSesionAjax.php';
require_once __DIR__ . '/backend/interfaces.php';
include_once __DIR__ . '/backend/fabrica.php';
include_once __DIR__ . '/backend/entidades/empleado.php';

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno


$fabrica = new Fabrica('La fábrica');
$fabrica->SetCantidadMaxima(7);
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
    <title>LooneyTunes</title>
</head>

<body>

    <header>          
        <?php include_once __DIR__ . '/components/navBar.php'; ?>
    </header>

    <div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Lista de empleados</h1>
        <p class="lead">Personajes de looney toones que forman parte de nuestra institución.</p>
    </div>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($fabrica->GetEmpleados() as $empleado) : ?>
                <div class="col-sm-6 col-md-4 d-flex justify-content-around">
                    <div class="card mt-5 mb-5" style="width: 200px; height: 400px">
                        <img src="./backend/<?php echo $empleado->GetPathFoto(); ?>" alt="..." width="100%" height="100%">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo  $empleado->GetApellido() . '-' . $empleado->GetNombre(); ?></h4>
                            <h5 class="card-text"><?php echo 'DNI '. $empleado->GetDni(); ?></h5>
                            <p class="card-text"><?php echo 'Sueldo $'. $empleado->GetSueldo(); ?></p>
                            <!-- <a href="#" class="btn btn-primary">Ver más info</a> -->
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>