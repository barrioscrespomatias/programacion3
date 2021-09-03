<?php

abstract class Persona{

    private $apellido;
    private $dni;
    private $nombre;
    private $sexo;

    public function __construct($apellido, $nombre, $dni, $sexo){
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->sexo = $sexo;
    }

    /**
     * GetApellido
     */

     public function GetApellido():string{
         return $this->apellido;
     }

    /**
     * GetNombre
     */

    public function GetNombre():string{
        return $this->nombre;
    }

    /**
     * GetDni
     */

    public function GetDni():int{
        return $this->dni;
    }

    /**
     * GetSexo
     */

    public function GetSexo():string{
        return $this->sexo;
    }

    /**
     * Hablar (abstracto). Retorna un string.
     */
    
     abstract function Hablar($idioma):string;

    /**
     * ToString. Retorna un string mostrando todos los datos de la persona, separados por un guión medio (-).
     */

     public function ToString():string{
         $personaToString = '';
         return $personaToString.=GetApellido().'-'.GetNombre().'-'.GetDni().'-'.GetSexo().'-';         
     }

}

?>