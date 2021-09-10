<?php

require_once './entidades/empleado.php';

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno

$apellido = isset($_POST['txtApellido']) ? $_POST['txtApellido'] : null;
$nombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : null;
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : null;
$sexo = isset($_POST['cboSexo']) ? $_POST['cboSexo'] : null;
$legajo = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
$sueldo = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
$turno = isset($_POST['rdoTurno']) ? $_POST['rdoTurno'] : null;


$newEmpleado = new Empleado($apellido,$nombre,$dni,$sexo,$legajo,$sueldo,$turno);

$file = fopen('./archivos/empleados.txt', "a");
$save = fwrite($file, $newEmpleado->ToString());


?>

<!-- html incrustado en php -->
<? if ($save !== false): ?>
    <a href="./mostrar.php">Go to Mostrar.php</a>    
<? endif; ?>

<?php

fclose($file);


?>