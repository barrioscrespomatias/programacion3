<?php

include_once __DIR__ . './validarSesion.php';
include_once __DIR__ . './entidades/empleado.php';


/**
 * Lectura del archivo
 * Reconstruccion de empleados en memoria.
 */

$file = fopen('./archivos/empleados.txt', "r");
?>

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
    <table>
      <thead>
        <tr>
          <th class="d-flex justify-content-lg-between mb-2"><h4>Info</h4></th>
        </tr>
        <tr>
          <td >
            <hr>
          </td>
        </tr>
      </thead>

      <?php

      while (!feof($file)) {
        //Trim lo uso para eliminar espacios en blanco
        $line = trim(fgets($file));
        //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
        if (strlen($line) > 6) {
          $employee = explode('\n\r', $line);
          //el employee es un array con una sola posicion y contien un string.
          //Ingresar a la primera posicion y hacer un explode para separar por '-'.
          $data = explode('-', $employee[0]);
          //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.
          $newEmpleado = new Empleado($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);

      ?>

          <!-- html incrustado en php -->

          <tbody>
            <tr>
              <td class="d-flex justify-content-lg-between">
                <span><?php echo $newEmpleado->ToString(); ?></span>
                <a href="./eliminar.php?txtLegajo=<?php echo $newEmpleado->GetLegajo(); ?>">Delete</a>
              </td>

            </tr>
          </tbody>

          <!-- end incrustado en php -->
      <?php
        }
      }

      fclose($file);

      ?>

      <!-- html incrustado en php -->
      <tr>
          <td >
            <hr>
          </td>
        </tr>

    </table>
    
  </div>
  <a href="../frontend/index.html">Alta de empleados</a>
  <a href="./cerrarSesion.php">Cerrar sesión</a>
</body>

</html>

<?php



?>