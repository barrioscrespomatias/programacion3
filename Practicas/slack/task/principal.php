<?php
session_start();
if(session_status() !== PHP_SESSION_ACTIVE)
header('Location: index.html');

$data = isset($_GET['data']) ? $_GET['data'] : null;
if($data !== null)
{
    //EJ_01
    // echo $data;    
    
    //EJ_02    
    $listadoPersonas = TraerDeArchivo('./archivos/alumnos.txt','listar');
    ob_start();    
    ?>
        <div class="datos">
            <h1>Legajo: <?php echo $_SESSION['legajo']; ?></h1>
            <h2>Nombre: <?php echo $_SESSION['nombre'] .'-'. $_SESSION['apellido']; ?></h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>
                        <h4>Lista de empleados</h4>
                    </th>
                </tr>       
            </thead>
                <?php foreach ($listadoPersonas as $persona) : ?>
            <tbody>
                <tr>
                <td class="col-md-6">
                    <span><?php echo $persona; ?></span>              
                </td>
                <?php endforeach; ?>   
            </tbody>
        </table> 
    
        <?php
        $table = ob_get_clean();
        if(ob_get_level() > 0) {ob_flush();}            
        echo $table;
}


function TraerDeArchivo($fileName, $accion,$legajo=null)
{
    $file = fopen($fileName, "r");
    $cantidadDeAtributos = 6;    
    $newPersona="";
    $listaPersonas = [];
    while (!feof($file)) {
        //Trim lo uso para eliminar espacios en blanco
        $line = trim(fgets($file));
        //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
        if (strlen($line) > $cantidadDeAtributos) {
            $employee = explode('\n\r', $line);
            //el employee es un array con una sola posicion y contien un string.
            //Ingresar a la primera posicion y hacer un explode para separar por '-'.
            $data = explode('-', $employee[0]);
            //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.            
            $newPersona = '-'. $data[1] .'-'. $data[2] .'-'. $data[3] .'-'. $data[4] . PHP_EOL;            
            array_push($listaPersonas,$newPersona);
        }
    }
    fclose($file);
    return $listaPersonas;
}



