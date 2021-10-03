<?php


class Producto
{
    public $nombre;
    public $origen;

    public function __construct($nombre, $origen)
    {
        $this->nombre = $nombre;
        $this->origen = $origen;
    }
    //Guarda producto en path
    public function GuardarJSON($path)
    {
        $stdObj = new stdClass();
        $stdObj->exito = false;
        $stdObj->mensaje = "No se ha guardado en el archivo";

        $nuevoProducto = new stdClass();
        $nuevoProducto->nombre = $this->nombre;
        $nuevoProducto->origen = $this->origen;
        
        //1)
        // Recuperar los datos del archivo
        // Preparar el archivo para que inicie y termine con [ ]
        // Escribir cada uno de los productos separados por una , menos el último.        

        //2)
        //Guardarlos de esta manera
        //Recuperarlos según una separación de /n/e
        //Hacer un json decode de cada una de las líneas obtenidos y formar el producto en memoria.        

        $file = fopen($path, "a");
        $stringGuardado = json_encode($nuevoProducto) . PHP_EOL;
        $save = fwrite($file, $stringGuardado);

        fclose($file);
        if ($save > 0) {
            $stdObj->exito = true;
            $stdObj->mensaje = "Se ha guardado en el archivo";
        }
        return $stdObj;
    }

    //Testing
    public static function TraerJSON():array
    {
        $listaProductos = [];
        //Controlar las lineas en un archivo
        
        if(file_exists('./archivos/productos.json'))
        {
            $file = new \SplFileObject('./archivos/productos.json', 'r');
            $file->seek(PHP_INT_MAX);
            $cantidadLineas =  $file->key(); 
            $i = 0;
    
            $file = fopen('./archivos/productos.json', "r");        
            while (!feof($file) && $i <$cantidadLineas) 
            {
                //Trim lo uso para eliminar espacios en blanco
                $line = trim(fgets($file));            
                $arrayProducto = explode('\n\r', $line);
                
                //El archivo contiene json, entonces se debe decodificarlo.
                $stdProducto = json_decode($arrayProducto[0]);
                $producto = new Producto($stdProducto->nombre,$stdProducto->origen);

                //posicion cero porque explode retorna un array con una posición en este caso.         
                array_push($listaProductos,$producto);
                $i++;
            }
            fclose($file);
        }
        return $listaProductos;
        
    }

    /**
     * Retorna un json con la informacion de la verificación
     */
    public static function VerificarProductoJSON($producto)
    {
        $listaProductos = Producto::TraerJSON();
        $stdObj = new stdClass();
        $stdObj->exito = false;
        $stdObj->mensaje = "No se ha podido compeltar la operacion";



        foreach($listaProductos as $aux)
        {
            if($aux->nombre == $producto->nombre && $aux->origen == $producto->origen)
            {
                $stdObj->exito = true;
                $cantidad = Producto::CantidadPorOrigen($aux->origen);
                $stdObj->mensaje = "Hay un total de $cantidad";
                break;
            }            
        }
        if(!$stdObj->exito)
        {
            $salida = Producto::ProductosPopulares();
            $stdObj->mensaje = $salida;
        }

        return $stdObj;
    }

    public static function CantidadPorOrigen($origen)
    {
        $listaProductos = Producto::TraerJSON();
        $contador = 0;
        foreach($listaProductos as $aux)
        {
            if($aux->origen  == $origen)
            {
                $contador++;
            }
        }
        return $contador;
    }

    public static function ProductosPopulares()
    {
        $listaProductos = Producto::TraerJSON();
        $cantidad = 0;
        $cantidadMaxima = 0;
        $productoMaximo = "";
        $flagPrimeraVuelta = true;
        
        $stringSalida = "El producto mas popular es ";
        foreach($listaProductos as $aux)
        {
            //busco la cantidad.
            $cantidad = Producto::CantidadPorOrigen($aux->origen);
            if($flagPrimeraVuelta)
            {
                $cantidadMaxima = $cantidad;
                $productoMaximo = $aux->nombre;
            }
            else
            {
                //Reviso si la cantidad actual es mayor a cantidad máxima anterior.
                if($cantidad>$cantidadMaxima)
                {
                    $cantidadMaxima = $cantidad;
                    $productoMaximo = $aux->nombre;
                }
            }
        }
        $stringSalida.= $productoMaximo;

        return $stringSalida;
    }
}
