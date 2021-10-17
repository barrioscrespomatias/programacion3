<?php
session_start();

/*
Agregar la página validarSesion.php que verifique si la variable de sesión DNIEmpleado existe o no.
En el caso de no existir, redireccionar hacia login.html.
*/

$cerroSesion = session_unset();
session_destroy();
if($cerroSesion)
    header('Location: ../frontend/login.php');






