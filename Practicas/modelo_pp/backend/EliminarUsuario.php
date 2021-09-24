<?php
include_once __DIR__ . '/clases/Usuario.php';
// EliminarUsuario.php: Si recibe el parámetro id por POST, más el parámetro accion con valor "borrar", se
// deberá borrar el usuario (invocando al método Eliminar).
// Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.

$id = isset($_POST['id']) ? $_POST['id'] : null;
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;

$salida = new stdClass();
$salida->exito = false;
$salida->mensaje = "No se ha eliminado al usuario.";

if($accion == 'borrar' && $id !== null)
{
    $eliminado = Usuario::Eliminar($id);
    if($eliminado === true)
    {
        $salida->exito = true;
        $salida->mensaje = "Se ha eliminado al usuario";
    }    
}
$retorno = json_encode($salida);
echo $retorno;
