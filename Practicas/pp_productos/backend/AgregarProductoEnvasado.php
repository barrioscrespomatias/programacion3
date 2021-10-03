<?php

require_once __DIR__ . '/clases/ProductoEnvasado.php';


// Se recibirán por POST los valores: codigoBarra, nombre, origen, precio y la foto
// para registrar un producto envasado en la base de datos.

// Verificar la previa existencia del producto envasado invocando al método Existe. Se le pasará como parámetro el
// array que retorna el método Traer.

// Si el producto envasado ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
// Si el producto envasado no existe, se invocará al método Agregar. La imagen se guardará en
// “./productos/imagenes/”, con el nombre formado por el nombre punto origen punto hora, minutos y segundos
// del alta (Ejemplo: tomate.argentina.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.


// Producto
//codigoBarra, nombre, origen, precio y la foto
$codigoBarra = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : null;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$origen = isset($_POST['origen']) ? $_POST['origen'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
$upload = false;

//eliminarEspacios
if($origen !== null)
$origen = str_replace(' ', '', $origen);     

//verificar existencia sin id ni foto.
$productoEnvasado = new ProductoEnvasado($nombre,$origen,null,$codigoBarra,$precio,null);
$listaProductosEnvasados = ProductoEnvasado::Traer();
$existe = $productoEnvasado->Existe($listaProductosEnvasados);

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido agregar el producto envasado";

if($existe)
{
    $objSalida->mensaje = "El producto envasado ya existe en la base de datos.";
}

// Si el producto envasado no existe, se invocará al método Agregar. La imagen se guardará en
// “./productos/imagenes/”, con el nombre formado por el nombre punto origen punto hora, minutos y segundos
// del alta (Ejemplo: tomate.argentina.105905.jpg).
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

else 
{
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
        $destinoFinal = './productos/imagenes/' . "$nombre.$origen." . date("His") . "." . pathinfo($destinoAux, PATHINFO_EXTENSION);
    
    
    
    
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
        //Agrego el producto a la base de datos. Antes se debe guardar el path correcto.
        $productoEnvasado->pathFoto = $destinoFinal;
        //Agregar el producto a la base de datos
        $agregado =  $productoEnvasado->Agregar();
        if($agregado) 
        {
            $objSalida->exito = true;
            $objSalida->mensaje = "Se ha agregado el producto envasado a la base de datos. ";
        }
    }
}

echo json_encode($objSalida);


?>