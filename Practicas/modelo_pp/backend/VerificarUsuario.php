<?php
include_once __DIR__ . '/clases/Usuario.php';
// VerificarUsuario.php: (POST) Se recibe el parámetro usuariojson (correo y clave, en formato de cadena
// JSON) y se invoca al método TraerUno.
// Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
$param = isset($_POST['param']) ? $_POST['param'] : null;

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "No se ha podido realizar la operacion";

if($param !== null)
{
    $obj = json_decode($param);
    $usuario = Usuario::TraerUno($obj);
    if($usuario !== false)
    {
        $obj->exito = true;
        $obj->mensaje = "Se ha completado la operacion";
    }
}
echo json_encode($obj);



