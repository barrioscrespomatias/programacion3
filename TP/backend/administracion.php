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


/**
 * Guardar en archivo de texto
 */

// if(file_exists('./archivos/empleados.txt'))
// echo 'existe';
// else
// echo 'no existe';

 $file = fopen('./archivos/empleados.txt', "a");


var_dump($file);

$save = fwrite($file, 'algo guarda');
echo 'llego!';
var_dump($save);
$result = $save !== false ? 'Se ha guardado con exito!' : 'Error al guardar!';
echo $result;




?>