<?php
include_once __DIR__ . '/clases/Empleado.php';
// Nota: La foto guardarla en Vbackend/empleados/fotos/, con el nombre formado por el nombre punto tipo
// punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg).

// AltaEmpleado.php: Se recibirán por POST todos los valores: nombre, correo, clave, id perfil, sueldo y foto
// para registrar un empleado en la base de datos.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$correo = isset($_POST['correo']) ? $_POST['correo'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;
$id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : null;
$sueldo = isset($_POST['sueldo']) ? $_POST['sueldo'] : null;
$file = isset($_FILES['foto']) ? $_FILES['foto'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha completado la operacion";

//Captura de la foto
//Imagen

// Nota: La foto guardarla en backend/empleados/fotos/, con el nombre formado por el nombre punto tipo
// punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg)

$upload = false;
$esImage = false;
$extension = "";
$tmpName = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : null;
$fecha = date("His");

//Destino auxiliar
$destinoAux = './empleados/fotos/' . $_FILES['foto']['name'];
$destinoFinal = './empleados/fotos/' . "$nombre.$fecha.".pathinfo($destinoAux,PATHINFO_EXTENSION);

if($file !== null)
{
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

if($nombre !== null &&
    $correo !== null &&
    $clave !== null &&
    $id_perfil !== null &&
    $sueldo !== null &&
    $file !== null && 
    $upload === true)
{
    // $id,$nombre,$correo, $clave,$id_perfil,$perfil,$foto,$sueldo
    $empleado = new Empleado(null,$nombre,$correo,$clave,$id_perfil,null,$destinoFinal,$sueldo);
    $agregado = $empleado->Agregar();
    if($agregado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha completado la operacion";
    }
}

echo json_encode($objSalida);