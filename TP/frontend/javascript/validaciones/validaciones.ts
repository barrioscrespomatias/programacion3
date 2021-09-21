/**
 * Carga la página incial:
 * Formulario
 * Tabla de empleados
 * Links
 */
window.onload = function() {
    
    CargarFormulario();
    CargarTablaEmpleados();
  };


const AdministrarValidaciones = (comunicacion:string) => {
    console.log(comunicacion);
    const validado = VerificarValidacionesLogin();
    if (validado) {
        console.log('Campos validados correctamente!');
    }
    else {
        console.log('Error al validar los campos');
    }

    switch(comunicacion)
    {
        case "alta":
            //método para comunicarse mediante ajaxArchivos
            AgregarEmpleadoAjax("alta");
            break;
        case "modificar":            
            //método para comunicarse mediante ajax   
            AgregarEmpleadoAjax("modificar");            
            break;
    }

}
/**
 * Corrobora que un campo este vacio.
 * @param data Recibe el valor del campo
 */
const ValidarCamposVacios = (id: string) => {
    let isNotVoid: string = (<HTMLInputElement>document.getElementById(id)).value;
    const lenght = isNotVoid.length;

    return lenght !== 0 ? true : false;
}

const ValidarRangoNumerico = (numberValue: number, min: number, max: number) => {

    return numberValue >= min && numberValue <= max ? true : false;
}

const ValidarCombo = (idSelect: string, notValue: string = "--") => {
    const selectValue: string = (<HTMLInputElement>document.getElementById(idSelect)).value;

    return selectValue !== notValue ? true : false;
}

/**
 * Retorna el valor del elemento (type=radio)
    seleccionado por el usuario. Verificar atributo checked. 
    1-> mañana
    2-> tarde
    3->noche   
 */
const ObtenerTurnoSeleccionado = () => {
    let exit: string = 'undefined';
    let radioValue: NodeListOf<HTMLElement> = document.getElementsByName("rdoTurno");

    radioValue.forEach(element => {
        if ((<HTMLInputElement>element).checked)
            exit = (<HTMLInputElement>element).value;
    });

    return exit;
}
/**
 * Recibe como parámetro el valor del turno
    elegido y retornará el valor del sueldo máximo.
    1 -> mañana
    2 -> tarde
    3 -> noche
 */
const ObtenerSueldoMaximo = () => {

    const turno = ObtenerTurnoSeleccionado();
    let maxSalary = 0;
    switch (turno) {
        case '1':
            maxSalary = 20000;
            break;
        case '2':
            maxSalary = 18500;
            break;
        case '3':
            maxSalary = 25000;
            break;
    }
    return maxSalary;
}

// AdministrarSpanError(string, boolean): void. Es la encargada de, según el parámetro
// booleano, ocultar o no al elemento cuyo id coincida con el parámetro de tipo string.

const AdministrarSpanError = (idSelect: string, esCorrecto: boolean): void => {
    const selectValue = (<HTMLInputElement>document.getElementById(idSelect));
    const selectValueError = (<HTMLInputElement>document.getElementById(idSelect + 'Error'));
    if (esCorrecto === false) {
        selectValueError.style.display = 'block';
    }
}

const VerificarValidacionesLogin = (): boolean => {

    const dni = ValidarCamposVacios('txtDni');
    AdministrarSpanError('txtDni', dni);

    const apellido = ValidarCamposVacios('txtApellido');
    AdministrarSpanError('txtApellido', apellido);

    const nombre = ValidarCamposVacios('txtNombre');
    AdministrarSpanError('txtNombre', nombre);

    const genero = ValidarCombo('cboSexo');
    AdministrarSpanError('cboSexo', genero);

    const legajo = ValidarCamposVacios('txtLegajo');
    AdministrarSpanError('txtLegajo', legajo);

    const turno = ObtenerTurnoSeleccionado();
    const sueldo = ValidarCamposVacios('txtSueldo');
    AdministrarSpanError('txtSueldo', sueldo);

    const foto = ValidarCamposVacios('txtFoto');
    AdministrarSpanError('txtFoto', foto); 
    
    // validacion numero de dni
    const dniInt: number = parseInt((<HTMLInputElement>document.getElementById('txtDni')).value, 10);
    const rangoDni = ValidarRangoNumerico(dniInt, 1000000, 55000000);


    // validacion sueldo maximo
    const sueldoMaximo = ObtenerSueldoMaximo();
    const sueldoInt: number = parseInt((<HTMLInputElement>document.getElementById('txtSueldo')).value, 10);
    const rangoSueldo = ValidarRangoNumerico(sueldoInt, 8000, sueldoMaximo);

    if(foto===false)
    alert('La foto no se ha cargado');

    // validando los campos
    const validado =
        dni !== false &&
            apellido !== false &&
            nombre !== false &&
            genero !== false &&
            legajo !== false &&
            turno !== 'undefined' &&
            sueldo !== false &&
            rangoDni !== false &&
            rangoSueldo !== false &&
            foto !== false
            ? true : false;

    return validado;

}
/**
 * Combina funcionalidad de ajax y sincrónico.
 * Si el valor del inputHidden es true, la comunicación será vía ajax.
 * @param dniEmpleado dni del empleado a ser modificado
 */
const AdministrarModificar = (dniEmpleado: string) => {

    const inputHiddenValue : string | undefined = (<HTMLInputElement>document.getElementById("inputHidden")).value;

    //Para el index.php sin ajax
    if(inputHiddenValue !== 'true')
    {
        (<HTMLInputElement>document.getElementById("inputHidden")).value = dniEmpleado;
        (<HTMLFormElement>document.getElementById("formModificar")).submit();
        console.log(dniEmpleado);
    }
    else //Con ajax
    {        
        CargarFormulario(dniEmpleado); 
    }
}
/**
 * Método utilizado para eliminar vía ajax
 * @param legajo legajo a eliminar
 */
const AdministrarEliminar = (legajo:string) =>
{
    const xmlHttp : XMLHttpRequest = new XMLHttpRequest(); 
    xmlHttp.open('POST', '../backend/eliminar.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send(`txtLegajo=${legajo}&opcion=eliminarAjax`);

    xmlHttp.onreadystatechange = () =>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            (<HTMLDivElement>document.getElementById('divTablaEmpleados')).innerHTML = xmlHttp.responseText;
        }
    }

}

/**
 * Métodos ajaxArchivos
 */

const CargarFormulario = (dniModificar?:string) =>{
    const xmlHttp : XMLHttpRequest = new XMLHttpRequest(); 
    xmlHttp.open('POST', '../backend/administracionAjax.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    

    if(dniModificar !== undefined)
    xmlHttp.send(`inputHidden=${dniModificar}&formulario=traerFormulario`);
    else
    xmlHttp.send('formulario=traerFormulario');
    

    xmlHttp.onreadystatechange = () =>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            (<HTMLDivElement>document.getElementById('divFormlario')).innerHTML = xmlHttp.responseText;
        }
    }
}

const CargarTablaEmpleados = () =>{
    const xmlHttp : XMLHttpRequest = new XMLHttpRequest(); 
    xmlHttp.open('POST', '../backend/administracionAjax.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send('tablaEmpleados=traerTablaEmpleados');

    xmlHttp.onreadystatechange = () =>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            (<HTMLDivElement>document.getElementById('divTablaEmpleados')).innerHTML = xmlHttp.responseText;
        }
    }
}
/**
 * Método utilizado para agregar empleados mediante ajax. (No lo utiliza index.php)
 * @param opcion permite saber qué tipo de accion se realiza modificar o alta.
 */
const AgregarEmpleadoAjax = (opcion?:string) =>
{
    const xmlHttp : XMLHttpRequest = new XMLHttpRequest();

    const dni: string = (<HTMLInputElement>document.getElementById('txtDni')).value;
    const apellido: string = (<HTMLInputElement>document.getElementById('txtApellido')).value;
    const nombre: string = (<HTMLInputElement>document.getElementById('txtNombre')).value;
    const sexo: string = (<HTMLInputElement>document.getElementById('cboSexo')).value;
    const legajo: string = (<HTMLInputElement>document.getElementById('txtLegajo')).value;
    const sueldo: string = (<HTMLInputElement>document.getElementById('txtSueldo')).value;    
    const turno: string = ObtenerTurnoSeleccionado();    
    const file: any = (<HTMLInputElement>document.getElementById('txtFoto'));

    // Archivo subido por Ajax
    const form : FormData = new FormData();
    form.append('txtDni', dni);
    form.append('txtApellido', apellido);
    form.append('txtNombre', nombre);
    form.append('cboSexo', sexo);
    form.append('txtLegajo', legajo);
    form.append('txtSueldo', sueldo);
    form.append('rdoTurno', turno);
    form.append('txtFoto', file.files[0]);

    /**
     *las variables 'opcion' simplemente hacer que desde el backend se retorne un mensaje ante cada situación. 
     * Mensaje para modificar o mensaje para un alta.
     * Si es utilizado el hdnModificar
     */

    if(opcion === 'alta')
    {
        form.append('opcion','altaAjax');
    }
    else
    {
        form.append('opcion','modificarAjax');
        form.append('hdnModificar','modificar');
    }    
    
    
    xmlHttp.open('POST','../backend/administracion.php',true);
    xmlHttp.setRequestHeader('enctype','multipart/form-data');
    xmlHttp.send(form);
    xmlHttp.onreadystatechange = () =>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200)
        {
            //Response text desde backend
            //Acá se carga la respuesta por el alta o  la modificación.
            console.log(xmlHttp.responseText);
            CargarTablaEmpleados();
            CargarFormulario();             
        }
    }
}




