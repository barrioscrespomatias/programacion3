<?php

class AccesoDatos{
    private static $objetoAceesoDatos;
    private $objetoPDO;

    /**
     * Constructor de objeto Acceso Datos
     * Se conecto a un nuevo PDO mediante MYSQL.
     * Recibe como parámetro la base de datos, el usuario y la clave.
     * db = base de datos
     * usuario 'root'
     * clave ''
     */
    private function __construct($db,$usuario,$clave)
    {
        try{

            $usuario='root';
            $clave = '';

            $this->objetoPDO = new PDO('mysql:host=localhost;'.'dbname='.$db.';charset=utf8', $usuario,$clave);
        }
        catch(PDOException $e)
        {
            echo "Error!!<br/>". $e->getMessage();
            die();
        }

    }
    /**
     * Retorna una consulta mediante el método prepare($sql)
     * por medio del SQL pasado como parámetro
     */
    public function RetornarConsulta ($sql){

        return $this->objetoPDO->prepare($sql);
    }

    /**
     * Retorna un nuevo objeto Acceso Datos - type Singleton
     */
    public static function RetornarObjetoAcceso() //singleton
    {
        if(!isset(AccesoDatos::$objetoAceesoDatos)){
            //nombre base de datos
            AccesoDatos::$objetoAceesoDatos = new AccesoDatos('pp_productos','root','');
        }

        return AccesoDatos::$objetoAceesoDatos;

    }

    /**
     * Evitar clonar el objeto.
     */
    public function __clone()
    {
        trigger_error('La clonacion de este objeto no esta permitida!!',E_USER_ERROR);
    }

}