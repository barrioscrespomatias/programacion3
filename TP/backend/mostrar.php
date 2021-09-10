<?php

include_once './entidades/empleado.php';


/**
 * Lectura del archivo
 * Reconstruccion de empleados en memoria.
 */

$file = fopen('./archivos/empleados.txt', "r");
echo 'Listado de empleados: <br><br>';
while(! feof($file))
  {             
    //Trim lo uso para eliminar espacios en blanco
    $line = trim(fgets($file));
    //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
    if(strlen($line)>6)
    {
        $employee = explode('\n\r',$line);
        //el employee es un array con una sola posicion y contien un string.
        //Ingresar a la primera posicion y hacer un explode para separar por '-'.
        $data = explode('-',$employee[0]);
        //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.
        $newEmpleado = new Empleado($data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$data[6]);        
        echo $newEmpleado->ToString().'<br>';        
    }      
  }

fclose($file);

?>

<!-- html incrustado en php -->
<a href="../frontend/index.html">Go to Index.html</a>    

<?php



?>