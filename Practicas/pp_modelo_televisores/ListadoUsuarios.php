<?php
include_once __DIR__ . './clases/Usuario.php';
// Se mostrará el listado de todos los usuarios en formato JSON

$objSalida = new stdClass();
$objSalida->mensaje = "No se ha podido cargar los usuarios";
$objSalida->exito = false;


    $listaUsuarios =  Usuario::TraerTodos();
    
    if(count($listaUsuarios)>0)
    {
        
        $objSalida->mensaje = "";
        $objSalida->exito = true;
        foreach ($listaUsuarios as $item) 
        {            
            
            $objSalida->mensaje.= $item->ToJSON();
        }
        
    }

echo json_encode($objSalida);
