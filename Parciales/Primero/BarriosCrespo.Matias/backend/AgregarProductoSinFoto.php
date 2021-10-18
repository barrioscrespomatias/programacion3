<?php
include_once __DIR__ . './clases/ProductoEnvasado.php';

// AgregarProductoSinFoto.php: Se recibe por POST el parámetro producto_json (codigoBarra, nombre, origen y
// precio), en formato de cadena JSON. Se invocará al método Agregar.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido agregar el producto";

$productoStd = json_decode($producto_json);

//sin id ni pathFoto
if($producto_json !== null)
{
    $producto = new ProductoEnvasado($productoStd->nombre,$productoStd->origen,null,$productoStd->codigoBarra,$productoStd->precio,null);
    $agregado = $producto->Agregar();
    if($agregado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha agregado el producto a la base de datos";
    }
}

echo json_encode($objSalida);