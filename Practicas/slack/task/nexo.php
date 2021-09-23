<?php
session_start();
//Datos a guardar
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
if($accion == null)
$accion = isset($_GET['accion']) ? $_GET['accion'] : null;

$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : null;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$legajo = isset($_POST['legajo']) ? $_POST['legajo'] : null;


switch($accion)
{
    case 'alta':
    case 'modificar':
                
        //Imagen
        $upload = false;
        $esImage = false;
        $extension = "";
        $foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;
        $tmpName = isset($_FILES['foto']) ? $_FILES['foto']['tmp_name'] : null;
        $destinoAux = './fotos/' . $_FILES['foto']['name'];
        $destinoFinal = './fotos/' . "$legajo.".pathinfo($destinoAux,PATHINFO_EXTENSION);

        if($foto !== null)
        {
            if(file_exists($destinoFinal))
            {
                //el archivo ya existe
            }
            else
            {
                //genero validaciones
                if($foto['size']<1000000)
                {
                    $esImage = getimagesize($foto['tmp_name']);
                    if($esImage)
                    {
                        $extension=pathinfo($destinoAux, PATHINFO_EXTENSION);
                        switch($extension)
                        {
                            case 'jpg':
                            case 'bmp':
                            case 'gif':
                            case 'png':
                            case 'jpeg':
                                if(move_uploaded_file($tmpName,$destinoFinal))
                                {
                                    $upload = true;                            
                                }
                        }
                    }
                }
            }
        }
    if($upload)
    {
        $stringGuardado = "";
        $stringGuardado .= "- $legajo - $apellido - $nombre - $destinoFinal". PHP_EOL;
        $guardado = GuardarEnArachivo('./archivos/alumnos.txt',$stringGuardado);
        if($guardado)
        echo "Guardado con éxito!";
        else
        echo "Error al guardar.";
    }
    break;    
    case 'listado':
        TraerDeArchivo('./archivos/alumnos.txt',$accion);
    break;
    case 'verificar':
        TraerDeArchivo('./archivos/alumnos.txt',$accion,$legajo);
    break;
    

}

function GuardarEnArachivo($nombreArchivo, $putString): bool
{
    // $file = fopen($nombreArchivo, "w");
    $file = fopen($nombreArchivo, "a");
    $save = fwrite($file, $putString);  
    $salida = $save > 0 && true;      
    fclose($file); 
    return $salida;
}

function TraerDeArchivo($fileName, $accion,$legajo=null)
{
    $file = fopen($fileName, "r");
    $cantidadDeAtributos = 6;
    $verificado = false;
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
            $newPersona="";
            $newPersona .= '-'. $data[1] .'-'. $data[2] .'-'. $data[3] .'-'. $data[4] . PHP_EOL; 
            
            if($accion == 'verificar')
            {
                if( $data[1] == $legajo)
                {
                    $_SESSION['legajo'] = $data[1];
                    $_SESSION['apellido'] = $data[2];
                    $_SESSION['nombre'] = $data[3]; 
                    header("Location: principal.php?data=$newPersona");
                    $verificado = true;
                    break;
                }                
            }
            //Sino es verificar, será listar
            else
            echo $newPersona;
        }
    }
    if($accion == 'verificar' && !$verificado)
    echo "El alumno con legajo $legajo no se encuentra en el listado";

    fclose($file);
}

