<?php
// ModificarUsuario.php: Se recibirán por POST los siguientes valores: usuariojson (id, nombre, correo, clave y
// id_perfil, en formato de cadena JSON), para modificar un usuario en la base de datos. Invocar al método
// Modificar.
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
include_once __DIR__ . '/clases/Usuario.php';

$usuarioJson = isset($_POST['usuario_json']) ? $_POST['usuario_json'] : null;

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha completado la operacion";

if($usuarioJson !== null)
{
    $usuarioStd = json_decode($usuarioJson);
    $usuarioAux = new Usuario($usuarioStd->id, $usuarioStd->nombre, $usuarioStd->correo, $usuarioStd->clave, $usuarioStd->id_perfil,null);
    $modificado = $usuarioAux->Modificar();
    if($modificado)
    {
        $objSalida->exito = true;
        $objSalida->mensaje = "Se ha ha completado la operacion";
    }
}
echo json_encode($objSalida);
