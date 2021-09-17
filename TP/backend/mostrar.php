<?php

include_once __DIR__ . './validarSesion.php';
include_once __DIR__ . './entidades/empleado.php';
include_once __DIR__ . './fabrica.php';


/**
 * Lectura del archivo
 * Reconstruccion de empleados en memoria.
 */

// $file = fopen('./archivos/empleados.txt', "r");
$fabrica = new Fabrica('La fábrica v.0.1.0');
$fabrica->SetCantidadMaxima(7);
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
?>

<!-- init thml -->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="../frontend/css/styles.css">
</head>
<body class="m-3">
  <h2>Listado de empleados</h2>
  <div class="container">
    <table class="col-sm-12">
      <thead>
        <tr>
          <th class="">
            <h4>Info</h4>
          </th>
        </tr>
        <!-- <tr>
          <td>
            <hr>
          </td>
        </tr> -->
      </thead>
          <?php foreach ($fabrica->GetEmpleados() as $newEmpleado) : ?>
        <!-- html incrustado en php -->
        <tbody>
          <tr>
            <td class="col-md-6">
              <span><?php echo $newEmpleado->ToString(); ?></span>              
            </td>
            <td class="col-md-2">              
              <img class="imgBackGroundTransparent" src="<?php echo $newEmpleado->GetPathFoto(); ?>" alt="img_empleado" height="90" width="90">
            </td>
            <td class="col-md-1">              
              <a href="./eliminar.php?txtLegajo=<?php echo $newEmpleado->GetLegajo(); ?>">Delete</a>
            </td>
            <td class="col-md-1">
              <input type="button" value="Modificar">
            </td>
          </tr>        
          <?php endforeach; ?>          
          <!-- <tr>
            <td>
              <hr>
            </td>
          </tr> -->
      </tbody>
    </table>   

  </div>
  <a href="../frontend/index.html">Alta de empleados</a>
  <a href="./cerrarSesion.php">Cerrar sesión</a>
</body>
</html>
<!-- end thml -->

