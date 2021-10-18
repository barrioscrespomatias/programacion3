<?php
session_start();
/*
Agregar la página validarSesion.php que verifique si la variable de sesión DNIEmpleado existe o no.
En el caso de no existir, redireccionar hacia login.html.
*/

$dni = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;
$url = getcwd();
if($dni === null )
{
    header('Location: /Programacion3/TP/frontend/login.php');
}

   


