<?php
require_once __DIR__ . './clases/Usuario.php';

// Se recibe por POST el email y la clave. Invocar al método GuardarEnArchivo



$email = isset($_POST['email']) ? $_POST['email'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido agregar el usuario";

if($email !== null && $clave !== null)
{
    $usuario = new Usuario($email,$clave);
    $objSalida  =   $usuario->GuardarEnArchivo($usuario);

}

echo json_encode($objSalida);
