<?php
include_once __DIR__ . '/clases/Producto.php';

$listaProductos =  Producto::TraerJSON();
if(count($listaProductos)>0)
{
    echo json_encode($listaProductos);
}
else
echo "No hay productos para mostrar";




