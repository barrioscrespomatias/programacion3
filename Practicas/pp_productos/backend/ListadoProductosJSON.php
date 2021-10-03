<?php
include_once __DIR__ . '/clases/Producto.php';
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido listar los productos.";

if($accion == 'listar')
{
    $listaProductos =  Producto::TraerJSON();
    if(count($listaProductos)>0)
    {
        $objSalida->mensaje = "";
        $objSalida->exito = true;
        foreach ($listaProductos as $item) 
        {            
            $objSalida->mensaje .= json_encode($item);
        }
        
    }
}

echo json_encode($objSalida);
