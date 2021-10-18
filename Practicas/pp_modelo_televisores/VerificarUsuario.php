<?php
include_once __DIR__ . './clases/Usuario.php';

$email = isset($_POST['email']) ? $_POST['email'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido verificar el usuario.";



// Se recibe por POST el email y la clave, si coinciden con algún registro del archivo JSON
// (VerificarExistencia), crear una COOKIE nombrada con el email del usuario que guardará la fecha actual (con
// horas, minutos y segundos). Luego ir a ListadoUsuarios.php.
// Caso contrario, retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

if($email !== null && $clave !== null)
{
    $usuario = new Usuario($email,$clave);
    // $listaUsuarios = Usuario::TraerJSON();

    $existe =  Usuario::VerificarExistencia($usuario);
    {
        $valorCookie = date("Y-m-d | h:i:sa");
        $nombreCookie = $usuario->GetEmail();
        //elimina espacios en blanco para nombres compuestos.            
        $nombreCookie = str_replace(' ', '', $nombreCookie);
        $cookieCreada = setcookie($nombreCookie, $valorCookie);
        if($cookieCreada)
        {            
            header('Location: ListadoUsuarios.php');
        }       

    }       
}

echo json_encode($objSalida);


