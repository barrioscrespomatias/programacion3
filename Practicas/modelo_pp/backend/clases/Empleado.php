<?php
include_once __DIR__ . 'Usuario.php';

class Empleado extends Usuario
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
    



}