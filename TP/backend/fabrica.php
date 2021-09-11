<?php

class Fabrica
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

    private function BuscarEmpleadoPorDni($employee)
    {
        $key = -1;
        $i = 0;
        foreach($this->empleados as $item)
        {
            if ($item->GetDni() === $employee->GetDni()) 
            {
                $key = $i;
                break;
            }
            $i++;            
        }
        return $key;
    }

    /**
     * Recibe un empleado y lo elimina del array mediante unset
     * Unset: Trabaja mediante key. Es necesario pasarle la key del empleado.
     * Si el dni del empleado coincide con el dni de alguno de los empleados, tomar la key.
     */
    public function EliminarEmpleado($employee)
    {
        $deleteKey = $this->BuscarEmpleadoPorDni($employee);
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
        $salida = "Bienvenidos a la fábrica " . $this->razonSocial . '<br>';
        $salida .= "**************************" . '<br><br>';
        $salida .= "Total de empleados " . Count($this->empleados) . '<br>';
        $salida .= "Total de sueldos " . $this->CalcularSueldos() . '<br>';
        $salida .= "Lista de empleados " . '<br><br>';
        foreach ($this->empleados as $empleoyee) {
            $salida .= $empleoyee->ToString() . '<br>';
        }
        
        return $salida;
    }


    public function TraerDeArchivo($fileName)
    {
    }
}

?>|