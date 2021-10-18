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

    public function ToJSON()
    {
        $newObj = new stdClass();
        $newObj->nombre = $this->nombre;
        $newObj->origen = $this->origen;    
        return json_encode($newObj);          
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
             
     
        $file = fopen($path, "a");
        $stringGuardado = $this->ToJSON() . PHP_EOL;
        $save = fwrite($file, $stringGuardado);

        fclose($file);
        if ($save > 0) {
            $stdObj->exito = true;
            $stdObj->mensaje = "Se ha guardado en el archivo";
        }
        return $stdObj;
    }


    public static function TraerJSON():array
    {
        $listaProductos = [];
                
        if(file_exists('./archivos/productos.json'))
        {
            //Controlar las lineas en un archivo
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
        $stdObj->mensaje = "No se ha podido verificar el producto";

        foreach($listaProductos as $aux)
        {
            if($aux->nombre == $producto->nombre && $aux->origen == $producto->origen)
            {
                $stdObj->exito = true;
                $cantidad = Producto::Cantidad($aux->origen, $aux->nombre);
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

    public static function Cantidad($origen, $nombre)
    {
        $listaProductos = Producto::TraerJSON();
        $contador = 0;
        foreach($listaProductos as $aux)
        {
            if($aux->origen  == $origen && $aux->nombre  == $nombre)
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
