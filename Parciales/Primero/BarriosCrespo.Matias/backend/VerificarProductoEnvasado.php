<?php
include_once __DIR__ . '/clases/ProductoEnvasado.php';
$obj_producto = isset($_POST['obj_producto']) ? $_POST['obj_producto'] : null;


// Se recibe por POST el parámetro obj_producto, que será una cadena JSON
// (nombre y origen), si coincide con algún registro de la base de datos (invocar al método Traer) retornará los datos
// del objeto (invocar al ToJSON). Caso contrario, un JSON vacío ({}).

$objSalida = new stdClass();
$objSalida = "{}";

$stdProducto = json_decode($obj_producto);

if($obj_producto !== null)
{
    $listaProductosEnvasados = ProductoEnvasado::Traer();
    $productoEnvasado = new ProductoEnvasado($stdProducto->nombre,$stdProducto->origen,null,null,null,null);    

    $productoExistente =  $productoEnvasado->Existe($listaProductosEnvasados);
    if($productoExistente)
    {
        
        foreach($listaProductosEnvasados as $producto)
        {
            if($producto->nombre == $productoEnvasado->nombre && $producto->origen == $productoEnvasado->origen)
            {
                $jsonSalida = $producto->ToJSON();
                $objSalida = json_decode($jsonSalida);
                break;
            }
        }
    }
}

echo json_encode($objSalida);
