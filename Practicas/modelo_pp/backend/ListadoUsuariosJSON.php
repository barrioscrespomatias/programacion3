<?php
include_once __DIR__.'/clases/Usuario.php';
// ListadoUsuariosJSON.php: (GET) Se mostrará el listado de todos los usuarios en formato JSON
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;

if ($accion !== null) 
{
    if ($accion == 'listar') 
    {
        $usuarios  = Usuario::TraerTodos();
        var_dump($usuarios);
    }
}




