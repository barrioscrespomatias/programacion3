<?php

include_once __DIR__ . '/interfaces.php';
include_once __DIR__ . '/entidades/empleado.php';

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

    public function GetEmpleados()
    {
        return $this->empleados;
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
     * Retorna el empleado según el legajo pasado como parámetro
     * Sino lo pudo encontrar, retorna null
     */
    public function BuscarEmpleadoPorDni($dni)
    {        
        foreach ($this->empleados as $item) 
        {
            if ($item->GetDni() === $dni)
                return $item;
        }
        return null;
    }

    /**
     * Recibe un empleado y lo elimina del array mediante unset
     * Unset: Trabaja mediante key. Es necesario pasarle la key del empleado.
     * Si el dni del empleado coincide con el dni de alguno de los empleados, tomar la key.
     */
    public function EliminarEmpleado($employee):bool
    {
        $eliminado = false;
        $deleteKey = $this->BuscarEmpleado($employee);
        unset($this->empleados[$deleteKey]);

        //Se reorganizan las keys
        $this->empleados = array_values($this->empleados);

        //Eliminar la foto
        if(file_exists($employee->GetPathFoto()))
            $eliminado = unlink($employee->GetPathFoto());

        return $eliminado;
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
     * Agrega los empleados a la instancia actual de la clase fábrica.
     * Recibe como argumento el path del file de donde recupera los empleados.
     */
    public function TraerDeArchivo($fileName)
    {
        $file = fopen($fileName, "r");
        $cantidadDeAtributos = 6;
        while (!feof($file)) {
            //Trim lo uso para eliminar espacios en blanco
            $line = trim(fgets($file));
            //6 es la cantidad de atributos que tiene el empleado (los - que tiene la frase.)
            if (strlen($line) > $cantidadDeAtributos) {
                $employee = explode('\n\r', $line);
                //el employee es un array con una sola posicion y contien un string.
                //Ingresar a la primera posicion y hacer un explode para separar por '-'.
                $data = explode('-', $employee[0]);
                //Ahora data tiene la informacion del empleado en un array por cada vuelta que de el while.
                $newEmpleado = new Empleado($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);                
                //Se construye el path ya que el mismo tiene un guion medio entre el dni y el apellido
                //El explode separa por guiones medios y me destruye el path de la foto.
                $newEmpleado->SetPathFoto($data[7].'-'.$data[8]);
                $this->AgregarEmpleado($newEmpleado);
            }
        }

        fclose($file);
    }

    public function CargarTablaEmpleados()
    {
        $ob = ob_start();    
        ?>   
    
        <h2>Listado de empleados</h2>            
            <table>
                <thead>
                <tr>
                    <th class="">
                    <h4>Info</h4>
                    </th>
                </tr>
                <!-- <tr>
                    <td>
                    <hr>
                    </td>
                </tr> -->
                </thead>
                    <?php foreach ($this->GetEmpleados() as $newEmpleado) : ?>
                <!-- html incrustado en php -->
                <tbody>
                    <tr>
                    <td class="col-md-6">
                        <span><?php echo $newEmpleado->ToString(); ?></span>              
                    </td>
                    <td class="col-md-2">              
                        <img class="imgBackGroundTransparent" src="../backend/<?php echo $newEmpleado->GetPathFoto(); ?>" alt="img_empleado" height="90" width="90">
                    </td>
                    <td class="col-md-1">              
                        
                        <input type="button" class = "btn btn-danger btn-sm" value="Eliminar" onclick="AdministrarEliminar(<?php echo $newEmpleado->GetLegajo();?>)">
                    </td>
                    <td class="col-md-1">
                        <input type="button" class = "btn btn-primary btn-sm" value="Modificar" onclick="AdministrarModificar(<?php echo $newEmpleado->GetDni();?>)">
                    </td>
                    </tr>        
                    <?php endforeach; ?>          
                    <tr>
                        <td>
                            <input type="hidden" name="inputHidden" id="inputHidden" value="true">            
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <hr>
                        </td>
                    </tr> -->
                </tbody>
            </table> 

            <?php
            $table = ob_get_clean();
            $ob = ob_flush();
            return $table;
    }

    public function CargarFormulario($readOnly,$dni,$apellido,$nombre,$legajo,$sueldo,$btn,$opcion, $hdnModificar)
    {
        if($hdnModificar == 'modificar')
        $opcion = 'modificar';
        else
        $opcion = 'alta';

        ob_start();
        ?>
            <!-- <div class="col-sm-4"> -->
                <table class="center">                
                        <tbody>
                            <tr>
                                <td>
                                    <h2>Datos personales</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            <!-- DNI -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="txtDni" class="form-label">DNI:</label>
                                    <input type="number" class="form-control" id="txtDni" name="txtDni" min="1000000" max="55000000" required value="<?php echo $dni ?>" <?php echo $readOnly ?>>
                                    <span class="m-1 text-danger hidden" id="txtDniError">*</span>
                                </td>
                            </tr>
                            <!-- Apellido -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="txtApellido" class="form-label">Apellido:</label>
                                    <input type="text" class="form-control" id="txtApellido" name="txtApellido" required value="<?php echo $apellido; ?>">
                                    <span class="m-1 text-danger hidden" id="txtApellidoError">*</span>
                                </td>
                            </tr>
                            <!-- Nombre -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="txtNombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" required value="<?php echo $nombre; ?>">
                                    <span class="m-1 text-danger hidden" id="txtNombreError">*</span>
                                </td>
                            </tr>
                            <!-- Genero -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="cboSexo" class="form-label">Sexo:</label>
                                    <select name="cboSexo" id="cboSexo" class="form-control">
                                        <option value="--" selected="--">Seleccione</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <span class="m-1 text-danger hidden" id="cboSexoError">*</span>
                                </td>
                            </tr>                    
                            <tr>
                                <td>
                                    <h4>Datos Laborales</h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            <!-- Legajo -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="txtLegajo" class="form-label">Legajo:</label>
                                    <input type="number" class="form-control" id="txtLegajo" name="txtLegajo" min="100" max="550" required value="<?php echo $legajo; ?>" <?php echo $readOnly ?>>
                                    <span class="m-1 text-danger hidden" id="txtLegajoError">*</span>
                                </td>
                            </tr>
                            <!-- Sueldo -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="txtSueldo" class="form-label">Sueldo:</label>
                                    <input type="number" class="form-control" id="txtSueldo" name="txtSueldo" min="8000" max="25000" step="500" required value="<?php echo $sueldo; ?>">
                                    <span class="m-1 text-danger hidden" id="txtSueldoError">*</span>
                                </td>
                            </tr>
                            <!-- Turno -->
                            <tr>
                                <td class="d-flex justify-content-lg-between m-2">
                                    <label for="rdoTurno" class="form-label">Turno:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdoTurno" value="1" checked>
                                        <label class="form-check-label" for="mañana">
                                            Mañana
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdoTurno" value="2">
                                        <label class="form-check-label" for="tarde">
                                            Tarde
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdoTurno" value="3">
                                        <label class="form-check-label" for="noche">
                                            Noche
                                        </label>
                                    </div>
                                    <span class="m-1 text-danger hidden" id="txtTurnoError">*</span>
                                </td>
                            </tr>
                            <!-- Input File -->
                            <tr>
                                <td>
                                    <label for="txtFoto">Foto:</label>
                                    <input type="file" accept="image/*" id="txtFoto" name="txtFoto">
                                    <span class="m-1 text-danger hidden" id="txtFotoError">*</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            <!-- Buttons -->
                            <tr>
                                <td>
                                    <input class="btn btn-danger float-end btn-sm" type="reset" value="Limpiar">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    
                                    <button type="submit" onclick="AdministrarValidaciones('<?php echo $opcion; ?>')" class="btn btn-primary btn-sm float-end" id="btnEnviar"><?php echo $btn; ?></button>
                                </td>
                            </tr>
                            <!-- Input Hidden -->
                            <tr>
                                <td>
                                    <input type="hidden" name="hdnModificar" id="hdnModificar" value="<?php echo $hdnModificar ?>">                     
                                </td>
                            </tr>
                        </tbody>                
                </table>
            
            <!-- </div> -->
                
        <?php
        $form = ob_get_clean();
        $ob = ob_flush();
        return $form;
    }
}
