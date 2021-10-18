<?php
include_once __DIR__ . '/clases/Producto.php';

// $objSalida = new stdClass();
// $objSalida->exito = false;
// $objSalida->mensaje = "No se ha podido listar los productos.";

$listaProductos =  Producto::TraerJSON();
echo "MOSTRAR!";
var_dump($listaProductos);
die();

if(count($listaProductos)>0)
{
    // $objSalida->mensaje = "";
    // $objSalida->exito = true;
    // foreach ($listaProductos as $item) 
    // {            
    //     $objSalida->mensaje .= json_encode($item);
    // }
        // $objSalida->mensaje = $listaProductos;
        echo json_encode($listaProductos);
}
else
echo "No hay productos para mostrar";


// echo json_encode($objSalida);

