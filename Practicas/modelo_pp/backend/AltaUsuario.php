<?php
include_once __DIR__ . '/clases/Usuario.php';

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$correo = isset($_POST['correo']) ? $_POST['correo'] : null;
$clave = isset($_POST['clave']) ? $_POST['clave'] : null;
$id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : null;

$stdObj = new stdClass();
$stdObj->exito = false;
$stdObj->mensaje = "No se ha agregado a la base de datos";

if($nombre !== null && $correo !== null && $clave !== null && $id_perfil !== null)
{
    $usuario = new Usuario(null,$nombre,$correo,$clave,$id_perfil);
    $agregado = $usuario->Agregar();
    if($agregado)
    {
        $stdObj->exito = true;
        $stdObj->mensaje = "Se ha agregado a la base de datos";
    }
}
echo json_encode($stdObj);


