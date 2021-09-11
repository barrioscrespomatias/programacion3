<?php

abstract class Persona
{

    private $apellido;
    private $dni;
    private $nombre;
    private $sexo;

    public function __construct($apellido, $nombre, $dni, $sexo)
    {
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->sexo = $sexo;
    }

    /**
     * GetApellido
     */

    public function GetApellido()
    {
        return $this->apellido;
    }

    /**
     * GetNombre
     */

    public function GetNombre()
    {
        return $this->nombre;
    }

    /**
     * GetDni
     */

    public function GetDni()
    {
        return $this->dni;
    }

    /**
     * GetSexo
     */

    public function GetSexo()
    {
        return $this->sexo;
    }

    /**
     * Hablar (abstracto). Retorna un string.
     */

    abstract function Hablar($idioma);

    /**
     * ToString. Retorna un string mostrando todos los datos de la persona, separados por un guión medio (-).
     */

    public function ToString()
    {

        $personaToString = '';
        $personaToString .= $this->GetApellido() . '-' . $this->GetNombre() . '-' . $this->GetDni() . '-' . $this->GetSexo() . '-';

        return $personaToString;
    }
}
