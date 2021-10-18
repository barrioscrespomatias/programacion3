<?php
include_once __DIR__ . '/clases/Producto.php';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
$origen = isset($_GET['origen']) ? $_GET['origen'] : null;


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No existe la cookie!";

$nombreCookie = $nombre . "_" . $origen;

$valorCookie = isset($_COOKIE["$nombreCookie"]) ? $_COOKIE["$nombreCookie"] : null;

if($valorCookie !== null)
{
    $objSalida->exito = true;
    $objSalida->mensaje = $valorCookie;
}

echo json_encode($objSalida);
