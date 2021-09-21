<?php

include_once __DIR__ . './fabrica.php';
include_once __DIR__ . './entidades/empleado.php';

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
            ob_start();    
    ?>
    <!-- <div style="width: 45%;"> -->
    
        <h2>Listado de empleados</h2>            
            <table>
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
                        <img class="imgBackGroundTransparent" src="../backend/<?php echo $newEmpleado->GetPathFoto(); ?>" alt="img_empleado" height="90" width="90">
                    </td>
                    <td class="col-md-1">              
                        <a class="btn btn-danger btn-sm" href="./eliminar.php?txtLegajo=<?php echo $newEmpleado->GetLegajo(); ?>">Delete</a>
                    </td>
                    <td class="col-md-1">
                        <input type="button" class = "btn btn-primary btn-sm" value="Modificar" onclick="AdministrarModificar(<?php echo $newEmpleado->GetDni();?>)">
                    </td>
                    </tr>        
                    <?php endforeach; ?>          
                    <tr>
                        <td>
                            <input type="hidden" name="inputHiddenAjax" id="inputHiddenAjax" value="true">            
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <hr>
                        </td>
                    </tr> -->
                </tbody>
            </table>            
    <!-- </div> -->
    

    <?php
    $table = ob_get_clean();
    ob_flush();
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


