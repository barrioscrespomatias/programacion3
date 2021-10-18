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
    //busca el producto por id.
    $productoBorrar =  ProductoEnvasado::BuscarPorId($productoStd->id);

    //Si el archivo existe, obtener la informacion del archivo.
    if (file_exists($productoBorrar->pathFoto))
    $infoArchivo = pathinfo($productoBorrar->pathFoto);

    //mover la foto
    $nuevoPath =   './productosBorrados/' . $productoBorrar->id . "." . $productoBorrar->nombre . ".borrado." . date("His") . "." . $infoArchivo['extension'];
    rename($productoBorrar->pathFoto, $nuevoPath);

    //Fin Extra

    //Ahora se guarda la informacion del archivo borrado con la nueva ubicacion de la foto.

    // GuardarEnArchivo: escribirá en un archivo de texto (./archivos/productos_envasados_borrados.txt) toda
    // la información del producto envasado más la nueva ubicación de la foto. La foto se moverá al
    // subdirectorio “./productosBorrados/”, con el nombre formado por el id punto nombre punto 'borrado'
    // punto hora, minutos y segundos del borrado (Ejemplo: 688.tomate.borrado.105905.jpg).
    $productoBorrar->pathFoto = $nuevoPath;
    $guardadoEnArchivo =  $productoBorrar->GuardarEnArchivo();


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
        echo json_encode($objSalida);
    }
}
else
{    
    $listaProductosBorrados = ProductoEnvasado::TraerDeArchivo('./archivos/productos_envasados_borrados.txt');
    
    
    ob_start();
    ?>

        <!-- codigoBarra,nombre,origen,precio -->
        <table border="1px" >
            <thead>               
                <tr>
                    <th><h4>Cod. Barra</h4></th>
                    <th><h4>Nombre</h4></th>
                    <th><h4>Origen</h4></th>
                    <th><h4>Precio</h4></th>
                    <th><h4>Imagen</h4></th>
                </tr>                         
            </thead>
            <?php foreach ($listaProductosBorrados as $producto) : ?>
                <!-- html incrustado en php -->
                <tbody>
                    <tr>
                        <td class="col-md-6">
                            <span><?php echo $producto->codigoBarra; ?></span>
                        </td>
                        <td class="col-md-6">
                            <span><?php echo $producto->nombre; ?></span>
                        </td>
                        <td class="col-md-6">
                            <span><?php echo $producto->origen; ?></span>
                        </td>
                        <td class="col-md-6">
                            <span><?php echo $producto->precio; ?></span>
                        </td>
                        <td class="col-md-2">
                            <img src="<?php echo $producto->pathFoto; ?>" alt="img_producto" height="90" width="90">
                        </td>                        
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>

        <?php
        $table = ob_get_clean();
        if (ob_get_level() > 0) {ob_flush();}           
        
        echo $table;
        // $objSalida->mensaje = $table;

}


    
    

?>


