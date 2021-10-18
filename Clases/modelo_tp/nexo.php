<?php
require_once 'usuario.php';

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;
$correo = isset($_POST['correo']) ? $_POST['correo'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;
$user_json = isset($_POST['user_json']) ? $_POST['user_json'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha completado la operacion";


switch ($opcion)
{
    case 'login':

    break;

    case 'alta':
    $userStd = json_decode($user_json);
    
    $nuevoUsuario = new Usuario(null, $userStd->correo,$userStd->clave,$userStd->nombre,$userStd->perfil);
    $agregado = $nuevoUsuario->Agregar();

    if($agregado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha podido completar la operacion!";
    }   
    break;

}

echo json_encode($objSalida);