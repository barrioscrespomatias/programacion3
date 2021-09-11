<?php

require_once __DIR__ . './entidades/empleado.php';
require_once __DIR__ . './fabrica.php';

$fabrica = new Fabrica('La fabriquita v.0.1');
$fabrica->SetCantidadMaxima(7);

//Carga empleados existentes en el archivo de texto
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
$cantidadPrevia = $fabrica->GetCantidadEmpleados();

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno
$apellido = isset($_POST['txtApellido']) ? $_POST['txtApellido'] : null;
$nombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : null;
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : null;
$sexo = isset($_POST['cboSexo']) ? $_POST['cboSexo'] : null;
$legajo = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
$sueldo = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
$turno = isset($_POST['rdoTurno']) ? $_POST['rdoTurno'] : null;

//Guardar en archivo
$newEmpleado = new Empleado($apellido,$nombre,$dni,$sexo,$legajo,$sueldo,$turno);
$fabrica->AgregarEmpleado($newEmpleado);
$fabrica->GuardarEnArchivo('./archivos/empleados.txt');
$cantidadActual = $fabrica->GetCantidadEmpleados();

if ($cantidadActual > $cantidadPrevia)
{
    echo '<h3>Empleado agregado con éxito!</h3>';
    echo '<a href="./mostrar.php">Go to Mostrar.php</a>';
}
else
{
    echo '<h3>Ocurrió un problema al agregar al empleado</h3>';
    echo '<a href="../frontend/index.html">Go to Index.html</a>';
}

?>