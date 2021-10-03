<?php
require_once 'Producto.php';
require_once 'IParte2.php';
require_once 'IParte3.php';
require_once 'AccesoDatos.php';


class ProductoEnvasado extends Producto implements IParte2,IParte3
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

        //(codigoBarra, nombre, origen y precio

        // $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigoBarra,nombre,origen,precio)"
        //     . "VALUES(:codigoBarra, :nombre, :origen, :precio)");

            //Con foto
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigoBarra,nombre,origen,precio,pathFoto)"
        . "VALUES(:codigoBarra, :nombre, :origen, :precio, :foto)");

        //bindParam asocia un valor con la clave del insert.        
        $consulta->bindParam(':codigoBarra', $this->codigoBarra, PDO::PARAM_STR);
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);  
        
        //Con foto
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

        // codigoBarra,nombre,origen,precio
        
        while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            
            $producto = new ProductoEnvasado(); 
            $producto->id = $fila->id;
            $producto->codigoBarra = $fila->codigoBarra;
            $producto->nombre = $fila->nombre;
            $producto->origen = $fila->origen;
            $producto->precio = $fila->precio;
            $producto->pathFoto = $fila->pathFoto;            

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

        // $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre,
        //     origen = :origen, codigoBarra = :codigoBarra, precio = :precio
        //     WHERE productos.id = :id");

        // Con foto
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre,
        origen = :origen, codigoBarra = :codigoBarra, precio = :precio, pathFoto = :foto
        WHERE productos.id = :id");

        $consulta->bindParam(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindParam(':codigoBarra', $this->codigoBarra, PDO::PARAM_INT);   
        //con foto
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

        $file = fopen('./archivos/productos_envasados_borrados.txt', "w"); 
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
}