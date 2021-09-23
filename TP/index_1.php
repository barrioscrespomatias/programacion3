<?php

// include_once __DIR__ . './backend/validarSesion.php';
require_once __DIR__ . '/backend/interfaces.php';
include_once __DIR__ . '/backend/fabrica.php';
include_once __DIR__ . '/backend/entidades/empleado.php';

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno


$fabrica = new Fabrica('La fábrica');
$fabrica->SetCantidadMaxima(7);
$fabrica->TraerDeArchivo('./backend/archivos/empleados.txt');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- init bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    
    <!-- card css -->
    <link rel="stylesheet" link href="./frontend/css/card_1.css">

   
    <title>LooneyTunes</title>
</head>

<body>   

   

    <div class="container">
        <div class="row">
            <?php foreach ($fabrica->GetEmpleados() as $empleado) : ?>

                <div class="card">
                    <div class="card-header">
                    <img src="./backend/<?php echo $empleado->GetPathFoto(); ?>" alt="rover" />
                    </div>
                    <div class="card-body">
                    <span class="tag tag-teal"><?php echo  $empleado->GetApellido() . '-' . $empleado->GetNombre(); ?></span>
                    <h4>
                        Sueldo:
                    </h4>
                    <p>
                        <?php echo $empleado->GetSueldo(); ?>
                    </p>
                    <div class="user">
                        <img src="./backend/<?php echo $empleado->GetPathFoto(); ?>" alt="user" />
                        <div class="user-info">
                        <h5>July Dec</h5>
                        <small>2h ago</small>
                        </div>
                    </div>
                    </div>
                </div>
                

            <?php endforeach; ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>



    
    
