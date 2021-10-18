<?php
include_once __DIR__ . '/clases/ProductoEnvasado.php';

// Se recibirán por POST los siguientes valores: producto_json (id,
// codigoBarra, nombre, origen y precio, en formato de cadena JSON) y la foto (para modificar un producto
// envasado en la base de datos. Invocar al método Modificar.
// Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
// producto envasado a ser modificado.
// Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
// “./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
// minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : null;


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido modificar el producto envasado";

$productoStd = json_decode($producto_json);

//id,codigoBarra, nombre, origen y precio

if ($producto_json !== null) 
{
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
    $upload = false;

    //eliminarEspacios
    $origen = $productoStd->origen;
    if($origen !== null)
    {
        $origen = str_replace(' ', '', $origen);     
        $productoStd->origen = $origen;
    }
    
    
   
    if($foto !== null)
    {
        //Imagen
        $upload = false;
        $esImage = false;
        $extension = "";
        $tmpName = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : null;
    
        //Destino auxiliar
        //nombre punto origen punto hora, minutos y segundos del alta (Ejemplo: tomate.argentina.105905.jpg).
        $destinoAux = './productos/imagenes/' . $_FILES['foto']['name'];        
        $destinoFinal = './productos/imagenes/' . "$productoStd->nombre.$productoStd->origen." . date("His") . "." . pathinfo($destinoAux, PATHINFO_EXTENSION);
    
        // Validacion imagen
        if($foto !== null)
        {
            if(file_exists($destinoFinal))
            {
                //el archivo ya existe
            }
            else
            {
                //genero validaciones
                if($foto['size']<1000000)
                {
                    $esImage = getimagesize($foto['tmp_name']);
                    if($esImage)
                    {
                        $extension=pathinfo($destinoAux, PATHINFO_EXTENSION);
                        switch($extension)
                        {
                            case 'jpg':
                            case 'bmp':
                            case 'gif':
                            case 'png':
                            case 'jpeg':
                                if (move_uploaded_file($tmpName, $destinoFinal)) 
                                {
                                    $upload = true;
                                }
                        }
                    }
                }
            }
        }

    }   


    if($upload)
    {
        //genero el objeto de producto envasado modificado
        //id,codigoBarra, nombre, origen y precio
        $productoEnvasadoModificado = new ProductoEnvasado($productoStd->nombre,$productoStd->origen,$productoStd->id,$productoStd->codigoBarra,$productoStd->precio,$destinoFinal);        

        //Antes de modificar recupero el path de la foto original
        $productoOriginal = ProductoEnvasado::BuscarPorId($productoStd->id);
        $pathFotoOriginal = $productoOriginal->pathFoto;

        //Modifica el producto a la base de datos
        $modificado =  $productoEnvasadoModificado->Modificar();
        if($modificado) 
        {
            // Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
            // “./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
            // minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
            
            //Mover la foto original
            rename($pathFotoOriginal, './productosModificados/' . $productoEnvasadoModificado->nombre . "." . $productoEnvasadoModificado->origen . ".modificado." . date("His") . "." . $extension);    

            $objSalida->exito = true;
            $objSalida->mensaje = "Se ha modificado el producto envasado en la base de datos. ";
        }
    }
    
}

echo json_encode($objSalida);