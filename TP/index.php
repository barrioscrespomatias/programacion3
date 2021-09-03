<?php

require_once './backend/entidades/empleado.php'

//$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno
$e1 = new Empleado('Pedro','Rodriguez',1111,'M',1111,25000,'Tarde');
$e1->ToString();


?>