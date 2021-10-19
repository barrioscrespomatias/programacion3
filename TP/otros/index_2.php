<?php

// include_once __DIR__ . './backend/validarSesion.php';
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
    <link rel="stylesheet" link href="./frontend/css/card_2.css">
    <!-- custom css -->
    <!-- <link rel="stylesheet" link href="./frontend/css/styles.css"> -->
    <title>LooneyTunes</title>
</head>

<body>

    <header>          
        <?php include_once __DIR__ . '/components/navBar.php'; ?>
    </header>

    <div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Maria Juliana</h1>
        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt quam eius ex, ab vel delectus fuga tempore illum magni. Molestias temporibus, quisquam id maxime placeat ipsam sint. Animi, vero impedit!</p>
    </div>
    </div>

    <!-- <div class="container">
        <div class="row"> -->
        <body>
        
            <?php foreach ($fabrica->GetEmpleados() as $empleado) : ?>

                
        <head>
        <title>Harvest vase</title>
        <link href="https://fonts.googleapis.com/css?family=Bentham|Playfair+Display|Raleway:400,500|Suranna|Trocchi" rel="stylesheet">
        </head>
            
        <div class="wrapper m-6 col-md-6">
            <div class="product-img">
                <img src="./backend/<?php echo $empleado->GetPathFoto(); ?>" height="420" width="327">
            </div>
            <div class="product-info">
                <div class="product-text">
                    <h1>Harvest Vase</h1>
                    <h2>by studio and friends</h2>
                    <p>Harvest Vases are a reinterpretation<br> of peeled fruits and vegetables as<br> functional objects. The surfaces<br> appear to be sliced and pulled aside,<br> allowing room for growth. </p>
                </div>
                <div class="product-price-btn">
                    <p><span>78</span>$</p>
                    <button type="button">buy now</button>
                </div>
            </div>
        
        </div> 
            <?php endforeach; ?>
        

        </body>
        <!-- </div>
    </div> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>






