<?php
require_once 'Producto.php';
require_once 'IParte1.php';
require_once 'IParte2.php';
require_once 'IParte3.php';
require_once 'AccesoDatos.php';


class ProductoEnvasado extends Producto implements IParte1, IParte2, IParte3
{
    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;

    /**
     * Corroborar cuando es necesario nullear los campos.
     */
    public function __construct($nombre=null, $origen=null, $id=null, $codigoBarra=null, $precio=null, $pathFoto=null)
    {
        parent::__construct($nombre,$origen);
        $this->id = $id;
        $this->codigoBarra = $codigoBarra;
        $this->precio = $precio;
        $this->pathFoto = $pathFoto;
    }

    public function ToJSON()
    {
        $newObj = new stdClass();
        $newObj->nombre = $this->nombre;
        $newObj->origen = $this->origen;
        $newObj->id = $this->id;
        $newObj->codigoBarra = $this->codigoBarra;
        $newObj->precio = $this->precio;
        $newObj->pathFoto = $this->pathFoto;

        return json_encode($newObj);          
    }

    //Impelemntacion interfaz

    // Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla productos (id, codigo_barra,
    // nombre, origen, precio, foto), de la base de datos productos_bd. Retorna true, si se pudo agregar, false,
    // caso contrario
    
    /**
     * Retorna booleano
     */
    public function Agregar():bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();        

        // (codigoBarra, nombre, origen y precio

        if($this->pathFoto == null)
         {
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigo_barra,nombre,origen,precio)"
            . "VALUES(:codigo_barra, :nombre, :origen, :precio)");

        }
        else {
            //Con foto
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigo_barra,nombre,origen,precio,foto)"
            . "VALUES(:codigo_barra, :nombre, :origen, :precio, :foto)");
        }


          
        //bindParam asocia un valor con la clave del insert.        
        $consulta->bindParam(':codigo_barra', $this->codigoBarra, PDO::PARAM_STR);
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);  
        
        //Con foto
        if($this->pathFoto !== null)
        $consulta->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);  


        $retorno = $consulta->execute();

        return $retorno;
    }

    // Traer: este método estático retorna un array de objetos de tipo ProductoEnvasado, recuperados de la
    // base de datos.

    /**
     * Retorna array de objetos de tipo producto envasado
     */
    public static function Traer():array
    {
        //retorna una lista de empleados.
        $listaProductos = array();
        $objetoAccesoDatos = AccesoDatos::RetornarObjetoAcceso();         
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM productos"); 
        
        //Atenti con el alias. 
        $consulta->execute(); 

        // codigoBarra,nombre,origen,precio, pathFoto
        
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            
            $producto = new ProductoEnvasado(); 
            $producto->id = $fila->id;
            $producto->codigoBarra = $fila->codigo_barra;
            $producto->nombre = $fila->nombre;
            $producto->origen = $fila->origen;
            $producto->precio = $fila->precio;
            $producto->pathFoto = $fila->foto;            

            array_push($listaProductos, $producto);
        }
        return $listaProductos;
    }

    /**
     * Implementación de interfaz IParte2.php
     */

    /** 
     * Retorna booleano
     * Eliminar: este método estático, elimina de la base de datos el registro coincidente con el id recibido cómo
     *  parámetro. Retorna true, si se pudo eliminar, false, caso contrario.       
     */
    public static function Eliminar($idEliminar):bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE productos.id = :id");

        $consulta->bindParam(':id', $idEliminar, PDO::PARAM_INT);        
        $consulta->execute();
        
        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;

        return $retorno;

    }

    /**
     *  Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
     *  Retorna true, si se pudo modificar, false, caso contrario.
     * 
     */
    public function Modificar():bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        // id, codigoBarra,nombre, origen y precio

        if($this->pathFoto == null)
        {
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre,
                origen = :origen, codigo_barra = :codigoBarra, precio = :precio
                WHERE productos.id = :id");

        }

        else
        {
            // Con foto
            $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre,
            origen = :origen, codigo_barra = :codigoBarra, precio = :precio, foto = :foto
            WHERE productos.id = :id");

        }

        $consulta->bindParam(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindParam(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);   

        //con foto
        if($this->pathFoto !== null)        
        $consulta->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);   
             
        $consulta->execute();

        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;
            
        return $retorno;
    }

    /**
     * Implementación IParte3
     */

    // Existe: retorna true, si la instancia actual está en el array de objetos de tipo ProductoEnvasado que recibe
    // como parámetro (comparar por nombre y origen). Caso contrario retorna false.
    public function Existe($listaProductosEnvasados):bool
    {
        $retorno = false;
        foreach ($listaProductosEnvasados as $producto)
        {
            if($this->nombre == $producto->nombre && $this->origen == $producto->origen)
            {
                $retorno = true;
                break;
            }
        }

        return $retorno;

    }

    // GuardarEnArchivo: escribirá en un archivo de texto (./archivos/productos_envasados_borrados.txt) toda
    // la información del producto envasado más la nueva ubicación de la foto. La foto se moverá al
    // subdirectorio “./productosBorrados/”, con el nombre formado por el id punto nombre punto 'borrado'
    // punto hora, minutos y segundos del borrado (Ejemplo: 688.tomate.borrado.105905.jpg)
    public function GuardarEnArchivo():bool
    {
        $retorno = false;

        $file = fopen('./archivos/productos_envasados_borrados.txt', "a"); 
        // $nombre=null, $origen=null, $id=null, $codigoBarra=null, $precio=null, $pathFoto=null       
        $stringGuardado = "$this->nombre - $this->origen - $this->id - $this->codigoBarra - $this->precio - $this->pathFoto" . PHP_EOL;
        $save = fwrite($file, $stringGuardado);
        if($save>0)
        $retorno = true;        
        fclose($file);

        return $retorno;
    }

    //  Muestra todo lo registrado en el archivo “productos_eliminados.json”. Para ello,
    //  agregar un método estático (en ProductoEnvasado), llamado MostrarBorradosJSON.

    public static function MostrarBorradosJSON()
    {   
        $path = './archivos/productos_eliminados.json';
        $file = fopen($path, "r");
        $cantidadDeAtributos = 1;

        $listaProductosBorrados = array();
        while (!feof($file)) {
            //Trim lo uso para eliminar espacios en blanco
            $line = trim(fgets($file));            
            if (strlen($line) > $cantidadDeAtributos) {
                $employee = explode('\n\r', $line);
                $producto =  json_decode($employee[0]);
                array_push($listaProductosBorrados, $producto);              
            }
        }

        fclose($file);

        return $listaProductosBorrados;
    }

    public static function BuscarPorId($id)
    {
        $listaProductosEnvasados = self::Traer();
        $retorno = new ProductoEnvasado();
        foreach($listaProductosEnvasados as $producto)
        {
            if($producto->id == $id)
            {
                $retorno = $producto;
                break;
            }
        }
        return $retorno;
    }

    /**
     * Traer de archivo
     */
    public static function TraerDeArchivo($fileName)
    {
        $file = fopen($fileName, "r");
        $listaProductosEnvasados = array();
        $cantidadDeAtributos = 6;
        while (!feof($file)) {
            //Trim lo uso para eliminar espacios en blanco
            $line = trim(fgets($file));
            //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
            if (strlen($line) > $cantidadDeAtributos) {
                $employee = explode('\n\r', $line);
                //el employee es un array con una sola posicion y contien un string.
                //Ingresar a la primera posicion y hacer un explode para separar por '-'.
                $data = explode(' - ', $employee[0]);
                //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.

                // $nombre=null, $origen=null, $id=null, $codigoBarra=null, $precio=null, $pathFoto=null
                $nuevoProducto = new ProductoEnvasado($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);                
                //Se construye el path ya que el mismo tiene un guion medio entre el dni y el apellido
                //El explode separa por guiones medios y me destruye el path de la foto.
                // $newEmpleado->SetPathFoto($data[7].'-'.$data[8]);
                array_push($listaProductosEnvasados,$nuevoProducto);
            }
        }

        fclose($file);
        return $listaProductosEnvasados;
    }

    public static function FiltrarProductosNombre($nombre)
    {
        $listaProductos = array();
        $filtrados = array();
        if($nombre !== null)
        {
            $listaProductos = ProductoEnvasado::Traer();
            foreach($listaProductos as $producto)
            {
                if($producto->nombre === $nombre)
                {
                    array_push($filtrados, $producto);
                }
            }
        }
        return $filtrados;
    }

    public static function FiltrarProductosOrigen($origen)
    {
        $listaProductos = array();
        $filtrados = array();
        if($origen !== null)
        {
            $listaProductos = ProductoEnvasado::Traer();
            foreach($listaProductos as $producto)
            {
                if($producto->origen === $origen)
                {
                    array_push($filtrados, $producto);
                }
            }
        }
        return $filtrados;
    }

    public static function FiltrarProductosNombreOrigen($nombre, $origen)
    {
        $listaProductos = array();
        $filtrados = array();
        if($origen !== null)
        {
            $listaProductos = ProductoEnvasado::Traer();
            foreach($listaProductos as $producto)
            {
                if($producto->nombre === $nombre && $producto->origen === $origen)
                {
                    array_push($filtrados, $producto);
                }
            }
        }
        return $filtrados;
    }


}