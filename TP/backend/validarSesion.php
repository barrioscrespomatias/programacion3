<?php
session_start();
/*
Agregar la página validarSesion.php que verifique si la variable de sesión DNIEmpleado existe o no.
En el caso de no existir, redireccionar hacia login.html.
*/
$status = session_status();

// _DISABLED = 0
// _NONE = 1
// _ACTIVE = 2

if(!session_status() === 1)
{
    header('Location: ../frontend/login.php?pagina=sincrona');     

}

// $dni = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;
// if($dni === null )
// {
//     header('Location: ../frontend/login.php?pagina=sincrona');     
// }
    


