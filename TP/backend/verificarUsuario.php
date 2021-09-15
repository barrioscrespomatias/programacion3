<?php
session_start();
require_once __DIR__ . './fabrica.php';

/*
El formulario de la pagina login.html, establecer el valor del “action” en
‘backend/verificarUsuario.php’.
En la página verificarUsuario.php se recibirán por POST el DNI y el apellido de un usuario. Con
estos datos se deberá determinar si existe un empleado dentro del archivo de texto (empleados.txt)
que coincida con los valores requeridos.
Si no existe un empleado en el archivo de texto, mostrar un mensaje de error y habilitar un link para
volver a login.html.
Si se encuentra al empleado, se deberá redireccionar hacia mostrar.php.
Nota: Para realizar el direccionamiento utilizar la función header. Ver funcionamiento en
http://php.net/manual/es/function.header.php

*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../frontend/css/styles.css">
  <title>Verificar Usuario</title>

</head>
<body>

<?php

$fabrica = new Fabrica('La fábrica v.0.1.0');
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
$txtDni = isset($_POST['txtDni']) ? $_POST['txtDni'] : null;
$txtApellido = isset($_POST['txtApellido']) ? $_POST['txtApellido'] : null;
$exist = $fabrica->BuscarEmpleadoPorDniApellido($txtDni,$txtApellido);

if($exist != null)
{
    $_SESSION['DNIEmpleado'] = $txtDni;
    header('Location: ./mostrar.php');
}
    
else
    {
        echo '<h2>Error al obtener el usuario</h2>';
        echo "<a href='../frontend/index.html'>Volver al Index.html</a>";
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous">
</script>
</body>
</html>