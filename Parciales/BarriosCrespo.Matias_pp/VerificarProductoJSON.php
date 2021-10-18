<?php
include_once __DIR__ . '/clases/Producto.php';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$origen = isset($_POST['origen']) ? $_POST['origen'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido verificar el producto.";

// Se recibe por POST el nombre y el origen, 
// si coinciden con algún registro del archivo
// JSON (VerificarProductoJSON), crear una COOKIE nombrada con el nombre y el origen del producto, separado
// con un guión bajo (limon_tucuman) que guardará la fecha actual (con horas, minutos y segundos) más el retorno
// del mensaje del método estático VerificarProductoJSON de la clase Producto
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido (agregar, aquí también, el
// mensaje obtenido del método VerificarProductoJSON)

if($nombre !== null && $origen !== null)
{
    $nuevoProducto = new Producto($nombre,$origen);
    $listaProductos = Producto::TraerJSON();

    foreach($listaProductos as $producto)
    {
        if($producto->nombre === $nuevoProducto->nombre && $producto->origen === $nuevoProducto->origen)
        {            
            $objSalida =  Producto::VerificarProductoJSON($nuevoProducto);
            //crear cookie            
            $valorCookie = date("h-i-s") . " - $objSalida->mensaje";
            $nombreCookie = $producto->nombre. "_" . $producto->origen;

            //elimina espacios en blanco para nombres compuestos.            
            $nombreCookie = str_replace(' ', '', $nombreCookie);            
            setcookie($nombreCookie,$valorCookie);
            break;
        }
    }

    
}

echo json_encode($objSalida);
