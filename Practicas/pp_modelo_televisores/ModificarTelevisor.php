<?php
require_once __DIR__ . '/clases/Televisor.php';
require_once __DIR__ . '/clases/AccesoDatos.php';

// Se recibirán por POST todos los valores (incluida una imagen) para modificar un televisor
// en la base de datos. Invocar al método Modificar.
// Redirigir hacia Listado.php.
// Si no se pudo modificar, se mostrará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo
// acontecido.


// Producto
 //`id`, `tipo`, `precio`, `pais`, `foto`}
 $id = isset($_POST['id']) ? $_POST['id'] : null;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$pais = isset($_POST['paisOrigen']) ? $_POST['paisOrigen'] : null;

$foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
$upload = false;

//eliminarEspacios
if($pais !== null)
$pais = str_replace(' ', '', $pais);     



$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido modificar el televisor";

 if($foto !== null)
    {
        //Imagen
        $upload = false;
        $esImage = false;
        $extension = "";
        $tmpName = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : null;
    
        //Destino auxiliar
        
        // La imagen guardarla en “./televisores/imagenes/”, con el nombre formado por el tipo punto paisOrigen punto
        // hora, minutos y segundos del alta (Ejemplo: led.china.105905.jpg).
        
        
        $destinoAux = './televisores/imagenes/' . $_FILES['foto']['name'];
        $destinoFinal = './televisores/imagenes/' . "$tipo.$pais." . date("His") . "." . pathinfo($destinoAux, PATHINFO_EXTENSION);
    
    
    
    
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
        
        $nuevoTelevisor = new Televisor($tipo,$precio,$pais,$destinoFinal);        
        $nuevoTelevisor->SetId($id);  
        //Agregar el producto a la base de datos
        $agregado =  $nuevoTelevisor->Modificar();
        if($agregado) 
        {

            // Si se pudo agregar se redirigirá hacia Listado.php. Caso contrario, se mostrará un JSON que contendrá: éxito(bool)
            // y mensaje(string) indicando lo acontecido.

            header('Location: Listado.php');
        }
    }


echo json_encode($objSalida);


?>