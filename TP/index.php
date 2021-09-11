<?php

include_once './backend/fabrica.php';
include_once './backend/entidades/empleado.php';

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno


$fabrica = new Fabrica('La fábrica');
$e1 = new Empleado('Rodriguez_e1','Pedro',1111,'M',1111,25000,'Tarde');
$e2 = new Empleado('Gomez_e2','juan',2222,'M',2222,15000,'Noche');
$e3 = new Empleado('Reppeto_e3','Nico',3333,'M',3333,25000,'Noche');

$fabrica->AgregarEmpleado($e3);
$fabrica->AgregarEmpleado($e1);
$fabrica->AgregarEmpleado($e3);
$fabrica->AgregarEmpleado($e2);
$fabrica->AgregarEmpleado($e3);
    $fabrica->EliminarEmpleado($e3);

// $idiomas = ['Ingles','Italiano','Frances'];
// $idiomasHablados = $e1->Hablar($idiomas);



echo $fabrica->ToString();




