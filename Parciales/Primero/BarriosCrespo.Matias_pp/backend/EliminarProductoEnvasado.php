<?php
include_once __DIR__ . './clases/ProductoEnvasado.php';

// Recibe el parámetro producto_json (id, nombre y origen, en formato de cadena
// JSON) por POST y se deberá borrar el producto envasado (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarJSON y pasarle
// './archivos/productos_eliminados.json' cómo parámetro.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido eliminar  el producto";

//id, nombre y origen
$productoStd = json_decode($producto_json);


if($producto_json !== null)
{
    $eliminado = ProductoEnvasado::Eliminar($productoStd->id);    
    if($eliminado)
    {
        $productoEliminado = new ProductoEnvasado($productoStd->nombre,$productoStd->origen, $productoStd->id,null,null,null);
        $msjEliminado = $productoEliminado->GuardarJSON('./archivos/productos_eliminados.json');

        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha eliminado el producto a la base de datos. ";
        $objSalida->mensaje.=$msjEliminado->mensaje;
    }
}

echo json_encode($objSalida);