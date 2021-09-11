<?php

include_once __DIR__ . './fabrica.php';
include_once __DIR__ . './entidades/empleado.php';

$fabrica = new Fabrica('Fábrica auxiliar');
$fabrica->SetCantidadMaxima(7);
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
$txtLegajo = isset($_GET['txtLegajo']) ? $_GET['txtLegajo'] : null;

//Buscar empleado retorna una instancia del empleado 
//Necesita incluir a entidades/empleado
$empleadoAEliminar = $fabrica->BuscarEmpleadoPorLegajo($txtLegajo);

if($empleadoAEliminar !== null)
{
    $fabrica->EliminarEmpleado($empleadoAEliminar);
    $fabrica->GuardarEnArchivo('./archivos/empleados.txt');
    echo '<h2>Se ha eliminado al empleado correctamente.</h2>';
}
else
echo '<h2>No se ha elminado al empleado.</h2>';
?>

<a href="./mostrar.php">Go to Mostrar.php</a>
<a href="../frontend/index.html">Go to Index.html</a>