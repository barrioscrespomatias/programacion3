<?php

include_once 'persona.php';


class Empleado extends Persona
{

    protected $legajo;
    protected $sueldo;
    protected $turno;

    public function __construct($apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno)
    {
        parent::__construct($apellido, $nombre, $dni, $sexo);
        $this->legajo = $legajo;
        $this->sueldo = $sueldo;
        $this->turno = $turno;
    }

    /**
     * 
     */
    public function GetLegajo()
    {
        return $this->legajo;
    }

    /**
     * 
     */
    public function GetSueldo()
    {
        return $this->sueldo;
    }

    /**
     * 
     */
    public function GetTurno()
    {
        return $this->turno;
    }




    /**
     * Hablar (polimorfismo). Retorna un string con el formato “El empleado habla Español, Inglés,
     * Francés”, siendo “Español, Inglés, Francés”, el valor del array recibido por parámetro.
     */
    public function Hablar($idiomas)
    {
        $salida = 'El empleado habla ';
        $lenght = Count($idiomas);
        $i = 0;
        foreach ($idiomas as $idioma) {
            $i < $lenght-1 ? $salida .= $idioma . ', ' : $salida .= 'y ' . $idioma . '.';
            $i++;
        }
        return $salida;
    }

    /**
     * ToString (polimorfismo). Retorna un string mostrando todos los datos del empleado, separados
     * por un guión medio (-). Reutilizar código.
     */
    public function ToString()
    {       
        $salida = parent::ToString(); 
        $salida .= $this->GetLegajo() . '-' . $this->GetSueldo() . '-' . $this->GetTurno().PHP_EOL;
        return $salida;
        
    }
}
