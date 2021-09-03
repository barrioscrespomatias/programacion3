<?php
    require_once './persona.php';

    public class Empleado extends Persona{

        protected $legajo;
        protected $sueldo;
        protected $turno;

        public function __construct($apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno){
            parent::__construct($apellido,$nombre,$dni,$sexo);
            $this->legajo = $legajo;
            $this->sueldo = $sueldo;
            $this->turno = $turno;
        }

        /**
         * 
         */
        public function GetLegajo():int{
            return $this->legajo;
        }

        /**
         * 
         */
        public function GetSueldo():double{
            return $this->sueldo;
        }

        /**
         * 
         */
        public function GetTurno():string{
            return $this->turno;
        }




        /**
         * Hablar (polimorfismo). Retorna un string con el formato “El empleado habla Español, Inglés,
         * Francés”, siendo “Español, Inglés, Francés”, el valor del array recibido por parámetro.
         */
        public function Hablar($idiomas):string{
            $salida = 'El empleado habla ';
            $lenght = Count($idiomas);
            $i = 0;
            foreach($idiomas as $idioma){
                $i < $lenght ? $salida.= $idioma.', ' : $salida.= 'y '.$idioma.'.'                
            }
            return $salida;
        }

        /**
         * ToString (polimorfismo). Retorna un string mostrando todos los datos del empleado, separados
         * por un guión medio (-). Reutilizar código.
         */
        public function ToString():string{
            $salida = $this->ToString();
            $salida.=GetLegajo().'-'.GetSueldo().'-'.GetTurno().'<br>';

        }




    }
?>