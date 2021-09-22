<?php
/*
Agregar la página validarSesion.php que verifique si la variable de sesión DNIEmpleado existe o no.
En el caso de no existir, redireccionar hacia login.html.
*/
if(! isset($_SESSION['DNIEmpleado'] ))
{
    header('Location: ../frontend/login.html');        
}
    


