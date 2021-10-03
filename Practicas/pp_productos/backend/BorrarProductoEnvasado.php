<?php

include_once __DIR__ . '/clases/ProductoEnvasado.php';

// Se recibe el parámetro producto_json (id, codigoBarra, nombre, origen, precio y
// pathFoto en formato de cadena JSON), se deberá borrar el producto envasado (invocando al método Eliminar).
// Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
// Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los productos
// envasados borrados y sus respectivas imagenes.

$producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : null;


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido borrar el producto envasado";

$productoStd = json_decode($producto_json);

//id, codigoBarra, nombre, origen, precio y pathFoto en formato de cadena JSON

if($producto_json !== null)
{

    //Extra
    $productoBorrar =  ProductoEnvasado::BuscarPorId($productoStd->id);
    $guardadoEnArchivo =  $productoBorrar->GuardarEnArchivo();

    if(file_exists($productoBorrar->pathFoto))
    $infoArchivo = pathinfo($productoBorrar->pathFoto);

    //mover la foto    
    rename($productoBorrar->pathFoto, './productosBorrados/' . $productoBorrar->id . "." . $productoBorrar->nombre . ".borrado." . date("His") . "." . $infoArchivo['extension']);    

    //Fin Extra


    //Generar el producto para llamar al método GuardarEnArchivo. 
    $eliminado =  ProductoEnvasado::Eliminar($productoStd->id);
    if($eliminado)
    {
        // $productoEnvasadoEliminado = new ProductoEnvasado($productoStd->nombre, $productoStd->origen,$productoStd->id, $productoStd->codigoBarra, $productoStd->precio, $productoStd->pathFoto);
        // $guardado = $productoEnvasadoEliminado->GuardarEnArchivo();
        // if($guardado)
        // {
            $objSalida->exito = true;
            $objSalida->mensaje = "Se ha borrado el producto envasado!";
        // }
    }
}

echo json_encode($objSalida);
    
    

?>


