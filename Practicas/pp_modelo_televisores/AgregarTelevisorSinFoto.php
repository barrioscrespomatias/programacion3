<?php
include_once __DIR__ . './clases/Televisor.php';
include_once __DIR__ . './clases/AccesoDatos.php';
// Se recibe por POST el tipo, el precio y el paisOrigen. Se invocará al método Agregar.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido


$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$paisOrigen = isset($_POST['paisOrigen']) ? $_POST['paisOrigen'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido agregar el televisor";


//sin id ni pathFoto
if($tipo !== null && $precio !== null && $paisOrigen !== null)
{
    $producto = new Televisor($tipo,$precio,$paisOrigen,null);
    $agregado = $producto->Agregar();
    if($agregado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha agregado el televisor a la base de datos";
    }
}

echo json_encode($objSalida);