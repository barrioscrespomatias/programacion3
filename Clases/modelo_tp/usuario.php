<?php
include_once 'AccesoDatos.php';

class Usuario
{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $perfil;

    public function __construct($id=null, $correo=null, $clave=null, $nombre=null, $perfil=null)
    {
        $this->id = $id;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->perfil = $perfil;
    }   

    public function Agregar()
    {
        $retorno = false;
        $objetoAccesoDato = AccesoDatos::RetornarObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,perfil)"
            . " VALUES(:correo, :clave, :nombre, :perfil)");


        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->id_perfil, PDO::PARAM_INT);
        
        try{

            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);

        }
        catch (PDOException $e)
        {
            echo($e->getMessage());
        }
        return $retorno;
    }

    // public function ObtenerUno($params)
    // {
    //     $objStd = json_decode($params);


    // }
    
}