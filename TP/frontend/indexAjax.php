<?php
session_start();
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
    <!-- custom css -->
    <link rel="stylesheet" href="./css/styles.css">
    <title>TP-01 Lab-Prog III</title>

</head>

<body>    
    <div class="row">
        <h2 class="col-md-12 text-center"><?php echo $titulo; ?></h2>
        <div id="divFormlario" class="col-md-4"></div>
        <div id="divTablaEmpleados" class="col-md-8"></div>
        <div id="divLinks" class="col-md-8"></div>
    </div>

    
    <script src="./javascript/validaciones/validaciones.js"></script>
</body>
</html>