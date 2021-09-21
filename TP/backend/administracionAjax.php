<?php

require_once __DIR__ . './entidades/empleado.php';
require_once __DIR__ . './fabrica.php';


$dniEmpleadoModificar = isset($_POST['inputHidden']) ? $_POST['inputHidden'] : null;
if($dniEmpleadoModificar !== null)
{
    $op = 'modificar';    
}
else
$op='alta';
$opcion = '';

$titulo = 'Alta de empleados';
$readOnly = '';
$btn = 'Enviar';
// $opcion = isset($_POST['opcion']) ? $_POST['opcion'] : null;


$dni = '';
$apellido = '';
$nombre = '';
$sexo='';
$legajo='';
$sueldo='';
$turno='';
$hdnModificar = '';



if($dniEmpleadoModificar!=null)
{
    $fabrica = new Fabrica('La fabriquita v.0.1.0');
    $fabrica->SetCantidadMaxima(7);
    $fabrica->TraerDeArchivo('../backend/archivos/empleados.txt');
    $empleado = $fabrica->BuscarEmpleadoPorDni($dniEmpleadoModificar);

    //parametros pagina modificar
    $titulo = 'Modificar empleado';
    $readOnly = 'readonly';
    $btn = 'Modificar';
    $hdnModificar = 'modificar';

    $dni = $empleado->GetDni();
    $apellido = $empleado->GetApellido();
    $nombre = $empleado->GetNombre();
    $sexo=$empleado->GetSexo();
    $legajo=$empleado->GetLegajo();
    $sueldo=$empleado->GetSueldo();
    $turno=$empleado->GetTurno(); 
    
}

$fabrica = new Fabrica('La fabriquita v.0.1');
$fabrica->SetCantidadMaxima(7);

//Carga empleados existentes en el archivo de texto
$fabrica->TraerDeArchivo('./archivos/empleados.txt');
$cantidadPrevia = $fabrica->GetCantidadEmpleados();

$fomulario = isset($_POST['formulario']) ? $_POST['formulario'] : null;
if($fomulario == 'traerFormulario')
{
    
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
                                
                                <button type="submit" onclick="AdministrarValidaciones('<?php echo $op; ?>')" class="btn btn-primary btn-sm float-end" id="btnEnviar"><?php echo $btn; ?></button>
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
    ob_flush();
    echo $form;
}


$tablaEmpleados = isset($_POST['tablaEmpleados']) ? $_POST['tablaEmpleados'] : null;
if($tablaEmpleados == 'traerTablaEmpleados')
{
    ob_start();    
    ?>
    <!-- <div style="width: 45%;"> -->
    
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
                    <?php foreach ($fabrica->GetEmpleados() as $newEmpleado) : ?>
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
                            <input type="hidden" name="inputHiddenAjax" id="inputHiddenAjax" value="true">            
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <hr>
                        </td>
                    </tr> -->
                </tbody>
            </table>            
    <!-- </div> -->
    

    <?php
    $table = ob_get_clean();
    ob_flush();
    echo $table;
}

// die();
$file = isset($_FILES['txtFoto']) ? $_FILES['txtFoto'] : null;
if ($file !== null) {
    // EMPLEADO
    //$apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno
    $apellido = isset($_POST['txtApellido']) ? $_POST['txtApellido'] : null;
    $nombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : null;
    $dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : null;
    $sexo = isset($_POST['cboSexo']) ? $_POST['cboSexo'] : null;
    $legajo = isset($_POST['txtLegajo']) ? $_POST['txtLegajo'] : null;
    $sueldo = isset($_POST['txtSueldo']) ? $_POST['txtSueldo'] : null;
    $turno = isset($_POST['rdoTurno']) ? $_POST['rdoTurno'] : null;
    $hdnModificar = isset($_POST['hdnModificar']) ? $_POST['hdnModificar'] : null;

    //Imagen
    $upload = false;
    $esImage = false;
    $extension = "";
    $file = isset($_FILES['txtFoto']) ? $_FILES['txtFoto'] : null;
    $tmpName = isset($_FILES['txtFoto']) ? $_FILES['txtFoto']['tmp_name'] : null;

    //Destino auxiliar
    $destinoAux = './fotos/' . $_FILES['txtFoto']['name'];
    $destinoFinal = './fotos/' . "$dni-$apellido." . pathinfo($destinoAux, PATHINFO_EXTENSION);

    if ($hdnModificar === 'modificar') {
        $empleadoModificar = $fabrica->BuscarEmpleadoPorDni($dni);
        $modificado = $fabrica->EliminarEmpleado($empleadoModificar);
    }

    if ($file !== null) {
        if (file_exists($destinoFinal)) {
            //el archivo ya existe
        } else {
            //genero validaciones
            if ($file['size'] < 1000000) {
                $esImage = getimagesize($file['tmp_name']);
                if ($esImage) {
                    $extension = pathinfo($destinoAux, PATHINFO_EXTENSION);
                    switch ($extension) {
                        case 'jpg':
                        case 'bmp':
                        case 'gif':
                        case 'png':
                        case 'jpeg':
                            if (move_uploaded_file($tmpName, $destinoFinal))
                                $upload = true;
                    }
                }
            }
        }
    }
}


switch ($opcion) {
    case 'modificar':
    case 'alta':

        //Agregar empleado en archivo
        $newEmpleado = new Empleado($apellido, $nombre, $dni, $sexo, $legajo, $sueldo, $turno);
        //Guardar el path del empleado
        $newEmpleado->SetPathFoto($destinoFinal);

        $fabrica->AgregarEmpleado($newEmpleado);
        $fabrica->GuardarEnArchivo('./archivos/empleados.txt');
        $cantidadActual = $fabrica->GetCantidadEmpleados();

        if($opcion == 'modificar')
        {
            echo $table;
        }
        else
        {
            if ($cantidadActual > $cantidadPrevia) {
                echo '<h3>Empleado agregado con éxito!</h3>';
                echo '<a href="./mostrar.php">Go to Mostrar.php</a>';
            } else if ($modificado) {
                echo '<h3>Empleado modificado con éxito!</h3>';
                echo '<a href="./mostrar.php">Go to Mostrar.php</a>';
            } else {
                echo '<h3>Ocurrió un problema al agregar al empleado</h3>';
                echo '<a href="../frontend/index.html">Go to Index.html</a>';
            }
        }

}




?>