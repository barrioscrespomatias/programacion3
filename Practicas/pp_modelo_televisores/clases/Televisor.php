<?php
include_once 'IParte2.php';
include_once 'IParte3.php';
class Televisor implements IParte2, IParte3
{
    public $tipo;
    public $precio;
    public $paisOrigen;
    public $path;
    public $id;

    //tipo, precio, paisOrigen y path
    public function __construct($tipo = null, $precio= null, $paisOrigen= null, $path= null)
    {
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->paisOrigen = $paisOrigen;
        $this->path = $path;
    }

    public function SetId($id)
    {
        $this->id = $id;
    }

    public function ToJSON()
    {
        $newObj = new stdClass();
        $newObj->tipo = $this->tipo;
        $newObj->precio = $this->precio;
        $newObj->paisOrigen = $this->paisOrigen;
        $newObj->path = $this->path;      

        return json_encode($newObj);
    }

    /**
     * IParte2
     */

     
    // ● Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla televisores (id, tipo, precio,
    // país, foto), de la base de datos productos_bd. Retorna true, si se pudo agregar, false, caso contrario.
    public function Agregar():bool
    {

        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();        

        //tipo, el precio y el paisOrigen
        //`id`, `tipo`, `precio`, `pais`, `foto`

        // $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO televisores (tipo,precio,pais)"
        //     . "VALUES(:tipo, :precio, :pais)");

            // Con foto
      $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO televisores (tipo,precio,pais,foto)"
            . "VALUES(:tipo, :precio, :pais, :foto)");

        //bindParam asocia un valor con la clave del insert.        
        
        $consulta->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindParam(':pais', $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindParam(':foto', $this->path, PDO::PARAM_STR);  
        
        //Con foto
        // $consulta->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);  


        $retorno = $consulta->execute();

        return $retorno;

    }

    // ● Traer: retorna un array de objetos de tipo Televisor, recuperados de la base de datos.
    public static function Traer():array
    {
         //retorna una lista de empleados.
         $listaProductos = array();
         $objetoAccesoDatos = AccesoDatos::RetornarObjetoAcceso();         
         $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM televisores"); 
         
         //Atenti con el alias. 
         $consulta->execute(); 
 
            //`id`, `tipo`, `precio`, `pais`, `foto`
         
         while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
             
             $producto = new Televisor(); 
            //  $producto->id = $fila->id;
             $producto->tipo = $fila->tipo;
             $producto->precio = $fila->precio;
             $producto->paisOrigen = $fila->pais; 
             $producto->path = $fila->foto;                     
 
             array_push($listaProductos, $producto);
         }
         return $listaProductos;
    }

    // ● CalcularIVA: retorna el precio del televisor más el 21%.
    public function CalcularIVA():float
    {
        return $this->precio*1.21;
    }

    public function Modificar():bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

             //`id`, `tipo`, `precio`, `pais`, `foto`

        // $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE televisores SET tipo = :tipo,
        //     precio = :precio, pais = :pais
        //     WHERE televisores.id = :id");

        // // Con foto
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE televisores SET tipo = :tipo,
        precio = :precio, pais = :pais, foto = :foto
        WHERE televisores.id = :id");


        $consulta->bindParam(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindParam(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindParam(':pais', $this->paisOrigen, PDO::PARAM_STR);
        $consulta->bindParam(':foto', $this->path, PDO::PARAM_STR);
        
        // //con foto
        // $consulta->bindParam(':foto', $this->pathFoto, PDO::PARAM_STR);   
             
        $consulta->execute();

        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;
            
        return $retorno;
    }

}
