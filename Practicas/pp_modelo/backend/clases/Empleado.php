<?php
include_once 'Usuario.php';
include_once 'ICRUD.php';

class Empleado extends Usuario implements ICRUD
{
    public $foto;
    public $sueldo;

    // public $id;
    // public $nombre;
    // public $correo;
    // public $clave;
    // public $id_perfil;
    // public $perfil;
    
    public function __construct($id,$nombre,$correo, $clave,$id_perfil,$perfil,$foto,$sueldo)
    {
        parent::__construct($id,$nombre,$correo,$clave,$id_perfil,$perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }

    // Métodos

    // TraerTodos (de clase): retorna un array de objetos de tipo Empleado, recuperados de la base de datos (con la
    // descripción del perfil correspondiente y su foto).
    // public static function TraerTodos():array
    // {
        
    // }

    // Agregar (de instancia): agrega, a partir de la instancia actual, un nuevo registro en la tabla empleados
    // (id,nombre, correo, clave, id_perfil, foto y sueldo), de la base de datos usuarios_test. Retorna true, si se pudo
    // agregar, false, caso contrario.
    // Nota: La foto guardarla en Vbackend/empleados/fotos/, con el nombre formado por el nombre punto tipo
    // punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg).
    public function Agregar():bool
    {
        // id,nombre, correo, clave, id_perfil, foto y sueldo

        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        // $id,$nombre,$correo, $clave,$id_perfil,$perfil,$foto,$sueldo

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,correo,clave,id_perfil,foto,sueldo)"
            . "VALUES(:nombre, :correo, :clave, :id_perfil, :foto, :sueldo)");

        //bindParam asocia un valor con la clave del insert.        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindParam(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);        
        $consulta->bindParam(':foto', $this->foto, PDO::PARAM_STR);   
        $consulta->bindParam(':sueldo',$this->sueldo, PDO::PARAM_STR);   

        $retorno = $consulta->execute();

        return $retorno;

    }

    // Modifica en la base de datos el registro coincidente con la instancia actual (comparar
    // por id). Retorna true, si se pudo modificar, false, caso contrario.
    // Nota: Si la foto es pasada, guardarla en Vbackend/empleados/fotos/, con el nombre formado por el nombre
    // punto tipo punto hora, minutos y segundos del alta (Ejemplo: juan.105905.jpg). Caso contrario, sólo actualizar
    // el campo de la base.
    public function Modificar():bool
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();
        
        //id, nombre, correo, clave, id_perfil, sueldo y pathFoto
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleados SET nombre = :nombre,
            correo = :correo, clave = :clave, id_perfil = :id_perfil, sueldo = :sueldo, foto = :foto
            WHERE empleados.id = :id");

        $consulta->bindParam(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindParam(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindParam(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT); 
        $consulta->bindParam(':sueldo', $this->sueldo, PDO::PARAM_STR); 
        $consulta->bindParam(':foto', $this->foto, PDO::PARAM_STR);         
        $consulta->execute();

        $filasAfectadas = $consulta->rowCount();
        if ($filasAfectadas > 0)
            $retorno = true;
            
        return $retorno;

    }

    // elimina de la base de datos el registro coincidente con el id recibido cómo parámetro.
    // Retorna true, si se pudo eliminar, false, caso contrario.
    // public static function Eliminar($id):bool
    // {

    // }
    



}