<?php
include_once __DIR__ . './clases/Usuario.php';
$email = isset($_GET['email']) ? $_GET['email'] : null;

// Se recibe por GET el email del usuario y se verificará si existe una cookie con el mismo
// nombre, de ser así, retornará un JSON que contendrá: éxito(bool) y mensaje(string), dónde se mostrará el
// contenido de la cookie. Caso contrario se retornará un JSON que contendrá: éxito(bool) y mensaje(string)
// indicando lo acontecido.


$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No existe la cookie!";

$nombreCookie = $email;

$valorCookie = isset($_COOKIE["$nombreCookie"]) ? $_COOKIE["$nombreCookie"] : null;

if($valorCookie !== null)
{
    $objSalida->exito = true;
    $objSalida->mensaje = str_replace('.', '_', $objSalida->mensaje);  
    $objSalida->mensaje = $valorCookie;
}

echo json_encode($objSalida);
