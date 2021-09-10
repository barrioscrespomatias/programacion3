<?php


include_once './backend/entidades/empleado.php';


//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno
$e1 = new Empleado('Rodriguez','Pedro',1111,'M',1111,25000,'Tarde');
echo  $e1->ToString();

$idiomas = ['Ingles','Italiano','Frances'];
$idiomasHablados = $e1->Hablar($idiomas);

var_dump($idiomasHablados);


