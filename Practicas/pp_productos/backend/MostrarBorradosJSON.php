<?php
require_once './clases/ProductoEnvasado.php';
//  Muestra todo lo registrado en el archivo “productos_eliminados.json”. Para ello,
//  agregar un método estático (en ProductoEnvasado), llamado MostrarBorradosJSON.

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido obtener el listado de borrados";

$listaBorrados = ProductoEnvasado::MostrarBorradosJSON();

if(count($listaBorrados)>0)
{
    $objSalida="";
    foreach ($listaBorrados as $productoBorrado)
    {
        $producto = new stdClass();
        $producto->item = json_encode($productoBorrado);
        $objSalida.=$producto->item;
    }
}

echo $objSalida;