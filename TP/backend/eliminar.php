<?php

include_once __DIR__ . '/fabrica.php';
include_once __DIR__ . '/entidades/empleado.php';

$fabrica = new Fabrica('Fábrica auxiliar');
$fabrica->SetCantidadMaxima(7);
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
$txtLegajo = isset($_GET['txtLegajo']) ? $_GET['txtLegajo'] : null;
$txtLegajoAjax = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;

//Buscar empleado retorna una instancia del empleado 
//Necesita incluir a entidades/empleado

if($opcion == 'eliminarAjax')
{
    $empleadoAEliminar = $fabrica->BuscarEmpleadoPorLegajo($txtLegajoAjax);    
}
else
$empleadoAEliminar = $fabrica->BuscarEmpleadoPorLegajo($txtLegajo);



    if($empleadoAEliminar !== null)
    {
        $fabrica->EliminarEmpleado($empleadoAEliminar);
        $fabrica->GuardarEnArchivo('./archivos/empleados.txt');

        if($opcion == null)
        {
            //
            echo '<h2>Se ha eliminado al empleado correctamente.</h2>';
        }
        else
        {
            //Acá es donde recibe el argumento desde ajax
            //retorna la lista de empleados.
            $table = $fabrica->CargarTablaEmpleados();
            echo $table; 
        }
        
    }
    else
    echo '<h2>No se ha elminado al empleado.</h2>';


    
    

?>

<?php if ($txtLegajoAjax == null): ?>
    <a href="./mostrar.php">Go to Mostrar.php</a>
    <a href="../frontend/index.html">Go to Index.html</a>
<?php endif; ?>


