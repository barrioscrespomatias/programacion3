<?php

require_once __DIR__ . './entidades/empleado.php';
require_once __DIR__ . './fabrica.php';

/**
 * Desde administracionAjax principalmente se cargan los formularios y la tabla de empleados
 * En cada solicitud y/o modificación viene hacia este archivo y refresca los datos.
 */


$dniEmpleadoModificar = isset($_POST['inputHidden']) ? $_POST['inputHidden'] : null;
$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;

$fomulario = isset($_POST['formulario']) ? $_POST['formulario'] : null;
$tablaEmpleados = isset($_POST['tablaEmpleados']) ? $_POST['tablaEmpleados'] : null;

//Datos del empleado por defecto

$titulo = 'Alta de empleados';
$readOnly = '';
$btn = 'Enviar';

$dni = '';
$apellido = '';
$nombre = '';
$sexo='';
$legajo='';
$sueldo='';
$turno='';
$hdnModificar = '';


$fabrica = new Fabrica('La fabriquita v.0.1.0');
$fabrica->SetCantidadMaxima(7);

//Datos del empleado si se va a realizar alguna modificación

if($dniEmpleadoModificar!=null)
{
    //Trae los empleados de la fábrica. Solo cuando se realiza una modificación
    $fabrica->TraerDeArchivo('../backend/archivos/empleados.txt');
    $empleado = $fabrica->BuscarEmpleadoPorDni($dniEmpleadoModificar);

    //parametros pagina modificar
    $titulo = 'Modificar empleado';
    $readOnly = 'readonly';
    $btn = 'Modificar';
    $hdnModificar = 'modificar';


    $dni = $empleado->GetDni();
    $apellido = $empleado->GetApellido();
    $nombre = $empleado->GetNombre();
    $sexo=$empleado->GetSexo();
    $legajo=$empleado->GetLegajo();
    $sueldo=$empleado->GetSueldo();
    $turno=$empleado->GetTurno(); 
    
}

//Trae los empleados de la fábrica. Solo cuando no se va a realizar una modificación.
$fabrica->TraerDeArchivo('./archivos/empleados.txt');

//Refresca el formulario en pantalla
if($fomulario !== null)
{
    $form = $fabrica->CargarFormulario($readOnly,$dni,$apellido,$nombre,$legajo,$sueldo,$btn,$opcion,$hdnModificar);
    echo $form;
}

//Refresca la tabla en pantalla
if($tablaEmpleados !== null)
{
    $table =  $fabrica->CargarTablaEmpleados();
    echo $table;
}

?>