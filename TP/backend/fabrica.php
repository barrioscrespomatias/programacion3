<?php

include_once __DIR__ . './interfaces.php';
include_once __DIR__ . './entidades/empleado.php';

class Fabrica implements IArchivo
{

    private $cantidadMaxima;
    private $empleados;
    private $razonSocial;

    function __construct($razonSocial)
    {
        $this->razonSocial = $razonSocial;
        $this->cantidadMaxima = 5;
        $this->empleados = [];
    }

    /**
     * 
     */
    public function SetCantidadMaxima($cantidad)
    {
        $this->cantidadMaxima = $cantidad;
    }

    public function GetCantidadEmpleados()
    {
        return Count($this->empleados);
    }

    /**
     * Agrega empleados si la cantidad es menor que la cantidad maxima admitia
     * Luego de agregar elimina los empleados repetidos.
     * Retorna un array sin los empleados repetidos ?
     */
    public function AgregarEmpleado($employee)
    {
        if (Count($this->empleados) < $this->cantidadMaxima) {
            array_push($this->empleados, $employee);
        }
        //Revisar si esta linea funciona correctamente.
        $this->empleados =  $this->EliminarEmpleadosRepetidos();
    }

    /**
     * Retorna el total de $ que la fabrica tiene que abonar en concepto de sueldos
     */
    public function CalcularSueldos()
    {
        $salary = 0;
        foreach ($this->empleados as $employee) {
            $salary += $employee->GetSueldo();
        }
        return $salary;
    }

    /**
     * Buscar empleado
     * Si el empleado existe en el array de empleados, retorna su key. Posicion del array.
     * Sino, retorna -1
     */

    private function BuscarEmpleado($employee)
    {
        $key = -1;
        $i = 0;
        foreach ($this->empleados as $item) {
            if (
                $item->GetDni() === $employee->GetDni() &&
                $item->GetApellido() === $employee->GetApellido() &&
                $item->GetNombre() === $employee->GetNombre() &&
                $item->GetTurno() === $employee->GetTurno()
            ) {
                $key = $i;
                break;
            }
            $i++;
        }
        return $key;
    }
    /**
     * Retorna el empleado según el legajo pasado como parámetro
     * Sino lo pudo encontrar, retorna null
     */
    public function BuscarEmpleadoPorLegajo($legajo)
    {        
        foreach ($this->empleados as $item) 
        {
            if ($item->GetLegajo() === $legajo)
                return $item;
        }
        return null;
    }

     /**
     * Retorna el empleado según el legajo pasado como parámetro
     * Sino lo pudo encontrar, retorna null
     */
    public function BuscarEmpleadoPorDniApellido($dni, $apellido)
    {        
        foreach ($this->empleados as $item) 
        {
            if ($item->GetDni() === $dni && $item->GetApellido() === $apellido)
                return $item;
        }
        return null;
    }

    /**
     * Recibe un empleado y lo elimina del array mediante unset
     * Unset: Trabaja mediante key. Es necesario pasarle la key del empleado.
     * Si el dni del empleado coincide con el dni de alguno de los empleados, tomar la key.
     */
    public function EliminarEmpleado($employee)
    {
        $deleteKey = $this->BuscarEmpleado($employee);
        unset($this->empleados[$deleteKey]);
    }

    /**
     * Retorna un array sin valores duplicados. Se debe llamar cada vez que se agrege un empleado.
     */
    private function EliminarEmpleadosRepetidos()
    {
        return array_unique($this->empleados, SORT_REGULAR);
    }

    /**
     * Cantidad maxima
     * Total de empleados
     * Listado de empleados
     * Razon social
     */


    /**
     * ToString. Retorna un string mostrando todos los datos de la fábrica (incluidos sus empleados),
     * separados por un guión medio (-).
     */

    public function ToString()
    {
        //MOSTRAR EMPLEADOS SEPARADOS POR UN GUION MEDIO
        $salida="";
        $salida .= "Bienvenidos a la fábrica " . $this->razonSocial . '<br>';
        $salida .= "**************************" . '<br><br>';
        $salida .= "Total de empleados " . Count($this->empleados) . '<br>';
        $salida .= "Total de sueldos " . $this->CalcularSueldos() . '<br>';
        $salida .= "Lista de empleados " . '<br><br>';
        foreach ($this->empleados as $empleoyee) {
            $salida .= $empleoyee->ToString() . '<br>';
        }

        return $salida;
    }

    /**
     * './archivos/empleados.txt
     */
    public function GuardarEnArchivo($nombreArchivo)
    {
        $file = fopen($nombreArchivo, "w");
        foreach ($this->empleados as $employee) {
            $save = fwrite($file, $employee->ToString());
        }
        fclose($file);
    }
    /**
     * './archivos/empleados.txt'
     */
    public function TraerDeArchivo($fileName)
    {
        $file = fopen($fileName, "r");
        while (!feof($file)) {
            //Trim lo uso para eliminar espacios en blanco
            $line = trim(fgets($file));
            //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
            if (strlen($line) > 6) {
                $employee = explode('\n\r', $line);
                //el employee es un array con una sola posicion y contien un string.
                //Ingresar a la primera posicion y hacer un explode para separar por '-'.
                $data = explode('-', $employee[0]);
                //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.
                $newEmpleado = new Empleado($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
                $this->AgregarEmpleado($newEmpleado);
            }
        }

        fclose($file);
    }
}
