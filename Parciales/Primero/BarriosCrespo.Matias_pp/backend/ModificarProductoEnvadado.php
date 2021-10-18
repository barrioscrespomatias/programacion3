<?php
include_once __DIR__ . '/clases/ProductoEnvasado.php';

// ModificarProductoEnvadado.php: Se recibirán por POST los siguientes valores: producto_json (id, codigoBarra,
// nombre, origen y precio, en formato de cadena JSON) para modificar un producto envasado en la base de datos.
// Invocar al método Modificar.
// Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
// producto envasado a ser modificado.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : null;


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido modificar el producto envasado";

$productoStd = json_decode($producto_json);

//id,codigoBarra, nombre, origen y precio

if ($producto_json !== null) 
{

    //eliminarEspacios
    $origen = $productoStd->origen;
    if($origen !== null)
    {
        $origen = str_replace(' ', '', $origen);     
        $productoStd->origen = $origen;
    }

    //genero el objeto de producto envasado modificado
    //id,codigoBarra, nombre, origen y precio
    $productoEnvasadoModificado = new ProductoEnvasado($productoStd->nombre,$productoStd->origen,$productoStd->id,$productoStd->codigoBarra,$productoStd->precio,null);        
    

    //Modifica el producto a la base de datos
    $modificado =  $productoEnvasadoModificado->Modificar();
    if($modificado) 
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha modificado el producto envasado en la base de datos. ";
    }
}

echo json_encode($objSalida);