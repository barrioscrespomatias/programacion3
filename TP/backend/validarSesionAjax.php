<?php
// session_start();
/*
Agregar la página validarSesion.php que verifique si la variable de sesión DNIEmpleado existe o no.
En el caso de no existir, redireccionar hacia login.html.
*/

$dni = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;
// $index = isset($_SESSION['index']) ? $_SESSION['index'] : null;
if($dni === null && $index === null)
{
    header('Location: ../frontend/login.php?pagina=ajax');        
}
// else if($dni === null && $index !== null)
// {
//     header('Location: /programacion3/TP/frontend/login.php?pagina=ajax');        
// }
// else if($dni !== null && $index !== null)
// {
//     header('Location: /programacion3/TP/');        
// }
    


