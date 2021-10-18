<?php
include_once __DIR__ . '/clases/Empleado.php';
// ModificarEmpleado.php: Se recibirán por POST los siguientes valores: empleadojson (id, nombre, correo,
// clave, id_perfil, sueldo y pathFoto, en formato de cadena JSON) y foto (para modificar un empleado en la base
// de datos. Invocar al método Modificar.

// Nota: El valor del id, será el id del empleado 'original, mientras que el resto de los valores serán los del
// empleado modificado.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido

$empleado_json = isset($_POST['empleado_json']) ? $_POST['empleado_json'] : null;
$file = isset($_FILES['foto']) ? $_FILES['foto'] : null;
$empleadoStd = json_decode($empleado_json);

$empleado = new Empleado($empleadoStd->id,$empleadoStd->nombre, $empleadoStd->correo, $empleadoStd->clave, $empleadoStd->id_perfil,null,$empleadoStd->pathFoto,$empleadoStd->sueldo);

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha completado la operacion";

//Captura de la foto
//Imagen

// Nota: La foto guardarla en backend/empleados/fotos/, con el nombre formado por el nombre punto tipo
// punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg)



if($file !== null)
{
    $upload = false;
    $esImage = false;
    $extension = "";
    $tmpName = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : null;
    $fecha = date("His");

    //Destino auxiliar
    $destinoAux = './empleados/fotos/' . $_FILES['foto']['name'];
    $destinoFinal = './empleados/fotos/' . "$empleado->nombre.$fecha.".pathinfo($destinoAux,PATHINFO_EXTENSION);
    
    if(file_exists($destinoFinal))
    {
        //el archivo ya existe
    }
    else
    {
        //genero validaciones
        if($file['size']<1000000)
        {
            $esImage = getimagesize($file['tmp_name']);
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
                        if(move_uploaded_file($tmpName,$destinoFinal))
                        {
                            $upload = true;                            
                        }
                }
            }
        }
    }
}

//validaciones
// id, nombre, correo, clave, id_perfil, sueldo y pathFoto
// si upload es false, solo se actualiza el path de la foto.

if($empleado->nombre !== null &&
    $empleado->correo !== null &&
    $empleado->clave !== null &&
    $empleado->id_perfil !== null &&
    $empleado->sueldo !== null && 
    $empleadoStd->pathFoto !== null)
    
{   
    // Sino se recibe el file la foto solo es modificada con el nuevo path.
    $agregado = $empleado->Agregar();
    if($agregado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha completado la operacion";
    }
}

echo json_encode($objSalida);