<?php
include_once __DIR__ . '/clases/Producto.php';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$origen = isset($_POST['origen']) ? $_POST['origen'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido guardar el producto.";

if($nombre !== null && $origen !== null)
{
    $nuevoProducto = new Producto($nombre,$origen);
    $objSalida = $nuevoProducto->GuardarJSON('./archivos/productos.json');
}

// return json_encode($objSalida);
echo json_encode($objSalida);


