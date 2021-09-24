<?php
include_once __DIR__ . '/AccesoDatos.php';
include_once 'IBM.php';

class Usuario implements IBM
{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public $id_perfil;
    public $perfil;

    public function __construct($id = null, $nombre=null, $correo=null, $clave=null, $id_perfil=null, $perfil= null)
    {        
        if ($id!==null) $this->id = $id;
        if ($nombre!==null) $this->nombre = $nombre;
        if ($correo!==null) $this->correo = $correo;
        if ($clave!==null) $this->clave = $clave;
        if ($id_perfil!==null) $this->id_perfil = $id_perfil;
        if ($perfil!==null) $this->perfil = $perfil;
    }

  
    /**
     * Retorna una instancia JSON del usuario con su nombre, correo y clave
     * 
     */
    public function ToJSON()
    {    
        $newObj = new stdClass();
        $newObj->nombre = $this->nombre;
        $newObj->correo = $this->correo;
        $newObj->clave = $this->clave;

        return json_encode($newObj);                
    }

    public function GuardarEnArchivo()
    {
        $stdObj = new stdClass();
        $stdObj->exito = false;
        $stdObj->mensaje = "No se ha guardado en el archivo";

        $file = fopen('./backend/archivos/usuarios.json', "a");       
        $save = fwrite($file, $this->ToJSON().PHP_EOL);   
        fclose($file);

        if($save>0)
        {
            $stdObj->exito = true;
            $stdObj->mensaje = "Se ha guardado en el archivo";
        }
        return json_encode($stdObj);
    }

    public function TraerTodosJSON():array
    {
        $usuarios = [];
        //Controlar las lineas en un archivo
        $file = new \SplFileObject('./backend/archivos/usuarios.json', 'r');
        $file->seek(PHP_INT_MAX);
        $cantidadLineas =  $file->key(); 
        $i = 0;

        $file = fopen('./backend/archivos/usuarios.json', "r");        
        while (!feof($file) && $i <$cantidadLineas) {
            //Trim lo uso para eliminar espacios en blanco
            $line = trim(fgets($file));            
            $employee = explode('\n\r', $line);   
            //posicion cero porque explode retorna un array con una posición en este caso.         
            array_push($usuarios,$employee[0]);
            $i++;
        }
        fclose($file);
        return $usuarios;
    }

    #region DB
    /**
     * Agregar a la base de datos
     */
    public function Agregar()
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,correo,clave,id_perfil)"
            . " VALUES(:nombre, :correo, :clave, :id_perfil)");

        //bindParam asocia un valor con la clave del insert.        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindParam(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);        

        $retorno = $consulta->execute();

        return $retorno;

    }

    public static function TraerTodos()
    {
         //retorna una lista de empleados.
         $listaDeUsuarios = array();
         $objetoAccesoDatos = AccesoDatos::RetornarObjetoAcceso();         
         $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM empleados"); 
         //Atenti con el alias. 
         $consulta->execute(); 
         
         while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
             $usuario = new Usuario(); 
             $usuario->nombre = $fila->nombre;
             $usuario->correo = $fila->correo;
             $usuario->clave = $fila->clave;
             $usuario->id_perfil = $fila->id_perfil;
             array_push($listaDeUsuarios, $usuario);
         }
         return $listaDeUsuarios;
    }
    /**
     * Método de clase TraerUno($params): retorna un objeto de tipo Usuario, de acuerdo al correo y clave que ser
     * reciben en el parámetro $params.    
     */
    public static function TraerUno($params)
    {
        $retorno = false;             

        //retorna una lista de empleados.
        $listaDeUsuarios = array();
        $objetoAccesoDatos = AccesoDatos::RetornarObjetoAcceso();         
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM empleados WHERE empleados.correo = :correo AND empleados.clave = :clave");         
        $consulta->bindParam(':clave', $params->clave, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $params->correo, PDO::PARAM_STR);
        $consulta->execute(); 

        //Traer un solo usuario de la DB.
        $usuarioAux = $consulta->fetch(PDO::FETCH_OBJ);
        if($usuarioAux !== false)
        {
            $usuario = new Usuario($usuarioAux->id, $usuarioAux->nombre, $usuarioAux->correo,$usuarioAux->clave,$usuarioAux->id_perfil,$usuarioAux->perfil);
            $retorno = $usuario;
        }
        

        return $retorno;

    }
    // Modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
    // Retorna true, si se pudo modificar, false, caso contrario
    public function Modificar():bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleados SET nombre = :nombre,
            correo = :correo, clave = :clave, id_perfil = :id_perfil
            WHERE empleados.id = :id");

        $consulta->bindParam(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindParam(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);        
        $consulta->execute();

        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;
            
        return $retorno;
    }

    // Eliminar (estático): elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
    // Retorna true, si se pudo eliminar, false, caso contrario.
    public static function Eliminar($id):bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM empleados WHERE empleados.id = :id");

        $consulta->bindParam(':id', $id, PDO::PARAM_INT);        
        $consulta->execute();
        
        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;

        return $retorno;
    }
   
    #endregion
}