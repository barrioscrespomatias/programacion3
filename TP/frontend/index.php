<?php
session_start();
include_once '../backend/fabrica.php';



$dniEmpleadoModificar = isset($_POST['inputHidden']) ? $_POST['inputHidden'] : null;

$titulo = 'Alta de empleados';
$readOnly = '';
$btn = 'Enviar';

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


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- init bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Formulario Alta de empleados</title>

</head>

<body>
    <h2><?php echo $titulo; ?></h2>
    <div class="container d-flex justify-content-lg-center">        
        
        <table class="center">
            <form action="../backend/administracion.php?pagina=ajax" method="POST" id="altaForm" enctype="multipart/form-data" >
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
                            <input class="btn btn-danger float-end btn-sm w-25" type="reset" value="Limpiar">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" onclick="AdministrarValidaciones()" class="btn btn-primary btn-sm float-end" id="btnEnviar"><?php echo $btn; ?></button>
                        </td>
                    </tr>
                    <!-- Input Hidden -->
                    <tr>
                        <td>
                            <input type="hidden" name="hdnModificar" id="hdnModificar" value="<?php echo $hdnModificar ?>">                     
                        </td>
                    </tr>
                </tbody>
            </form>
        </table>
    </div>

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    <script src="./javascript/validaciones/validaciones.js"></script>
</body>





</html>