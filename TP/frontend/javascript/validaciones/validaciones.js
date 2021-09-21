"use strict";
/**
 * Carga la página incial:
 * Formulario
 * Tabla de empleados
 * Links
 */
window.onload = function () {
    CargarFormulario();
    CargarTablaEmpleados();
};
var AdministrarValidaciones = function (comunicacion) {
    console.log(comunicacion);
    var validado = VerificarValidacionesLogin();
    if (validado) {
        console.log('Campos validados correctamente!');
    }
    else {
        console.log('Error al validar los campos');
    }
    switch (comunicacion) {
        case "alta":
            //método para comunicarse mediante ajaxArchivos
            AgregarEmpleadoAjax("alta");
            break;
        case "modificar":
            //método para comunicarse mediante ajax   
            AgregarEmpleadoAjax("modificar");
            break;
    }
};
/**
 * Corrobora que un campo este vacio.
 * @param data Recibe el valor del campo
 */
var ValidarCamposVacios = function (id) {
    var isNotVoid = document.getElementById(id).value;
    var lenght = isNotVoid.length;
    return lenght !== 0 ? true : false;
};
var ValidarRangoNumerico = function (numberValue, min, max) {
    return numberValue >= min && numberValue <= max ? true : false;
};
var ValidarCombo = function (idSelect, notValue) {
    if (notValue === void 0) { notValue = "--"; }
    var selectValue = document.getElementById(idSelect).value;
    return selectValue !== notValue ? true : false;
};
/**
 * Retorna el valor del elemento (type=radio)
    seleccionado por el usuario. Verificar atributo checked.
    1-> mañana
    2-> tarde
    3->noche
 */
var ObtenerTurnoSeleccionado = function () {
    var exit = 'undefined';
    var radioValue = document.getElementsByName("rdoTurno");
    radioValue.forEach(function (element) {
        if (element.checked)
            exit = element.value;
    });
    return exit;
};
/**
 * Recibe como parámetro el valor del turno
    elegido y retornará el valor del sueldo máximo.
    1 -> mañana
    2 -> tarde
    3 -> noche
 */
var ObtenerSueldoMaximo = function () {
    var turno = ObtenerTurnoSeleccionado();
    var maxSalary = 0;
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
};
// AdministrarSpanError(string, boolean): void. Es la encargada de, según el parámetro
// booleano, ocultar o no al elemento cuyo id coincida con el parámetro de tipo string.
var AdministrarSpanError = function (idSelect, esCorrecto) {
    var selectValue = document.getElementById(idSelect);
    var selectValueError = document.getElementById(idSelect + 'Error');
    if (esCorrecto === false) {
        selectValueError.style.display = 'block';
    }
};
var VerificarValidacionesLogin = function () {
    var dni = ValidarCamposVacios('txtDni');
    AdministrarSpanError('txtDni', dni);
    var apellido = ValidarCamposVacios('txtApellido');
    AdministrarSpanError('txtApellido', apellido);
    var nombre = ValidarCamposVacios('txtNombre');
    AdministrarSpanError('txtNombre', nombre);
    var genero = ValidarCombo('cboSexo');
    AdministrarSpanError('cboSexo', genero);
    var legajo = ValidarCamposVacios('txtLegajo');
    AdministrarSpanError('txtLegajo', legajo);
    var turno = ObtenerTurnoSeleccionado();
    var sueldo = ValidarCamposVacios('txtSueldo');
    AdministrarSpanError('txtSueldo', sueldo);
    var foto = ValidarCamposVacios('txtFoto');
    AdministrarSpanError('txtFoto', foto);
    // validacion numero de dni
    var dniInt = parseInt(document.getElementById('txtDni').value, 10);
    var rangoDni = ValidarRangoNumerico(dniInt, 1000000, 55000000);
    // validacion sueldo maximo
    var sueldoMaximo = ObtenerSueldoMaximo();
    var sueldoInt = parseInt(document.getElementById('txtSueldo').value, 10);
    var rangoSueldo = ValidarRangoNumerico(sueldoInt, 8000, sueldoMaximo);
    if (foto === false)
        alert('La foto no se ha cargado');
    // validando los campos
    var validado = dni !== false &&
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
};
/**
 * Combina funcionalidad de ajax y sincrónico.
 * Si el valor del inputHidden es true, la comunicación será vía ajax.
 * @param dniEmpleado dni del empleado a ser modificado
 */
var AdministrarModificar = function (dniEmpleado) {
    var inputHiddenValue = document.getElementById("inputHidden").value;
    //Para el index.php sin ajax
    if (inputHiddenValue !== 'true') {
        document.getElementById("inputHidden").value = dniEmpleado;
        document.getElementById("formModificar").submit();
        console.log(dniEmpleado);
    }
    else //Con ajax
     {
        CargarFormulario(dniEmpleado);
    }
};
/**
 * Método utilizado para eliminar vía ajax
 * @param legajo legajo a eliminar
 */
var AdministrarEliminar = function (legajo) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST', '../backend/eliminar.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send("txtLegajo=" + legajo + "&opcion=eliminarAjax");
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            document.getElementById('divTablaEmpleados').innerHTML = xmlHttp.responseText;
        }
    };
};
/**
 * Métodos ajaxArchivos
 */
var CargarFormulario = function (dniModificar) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST', '../backend/administracionAjax.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    if (dniModificar !== undefined)
        xmlHttp.send("inputHidden=" + dniModificar + "&formulario=traerFormulario");
    else
        xmlHttp.send('formulario=traerFormulario');
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            document.getElementById('divFormlario').innerHTML = xmlHttp.responseText;
        }
    };
};
var CargarTablaEmpleados = function () {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open('POST', '../backend/administracionAjax.php', true);
    xmlHttp.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xmlHttp.send('tablaEmpleados=traerTablaEmpleados');
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            document.getElementById('divTablaEmpleados').innerHTML = xmlHttp.responseText;
        }
    };
};
/**
 * Método utilizado para agregar empleados mediante ajax. (No lo utiliza index.php)
 * @param opcion permite saber qué tipo de accion se realiza modificar o alta.
 */
var AgregarEmpleadoAjax = function (opcion) {
    var xmlHttp = new XMLHttpRequest();
    var dni = document.getElementById('txtDni').value;
    var apellido = document.getElementById('txtApellido').value;
    var nombre = document.getElementById('txtNombre').value;
    var sexo = document.getElementById('cboSexo').value;
    var legajo = document.getElementById('txtLegajo').value;
    var sueldo = document.getElementById('txtSueldo').value;
    var turno = ObtenerTurnoSeleccionado();
    var file = document.getElementById('txtFoto');
    // Archivo subido por Ajax
    var form = new FormData();
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
    if (opcion === 'alta') {
        form.append('opcion', 'altaAjax');
    }
    else {
        form.append('opcion', 'modificarAjax');
        form.append('hdnModificar', 'modificar');
    }
    xmlHttp.open('POST', '../backend/administracion.php', true);
    xmlHttp.setRequestHeader('enctype', 'multipart/form-data');
    xmlHttp.send(form);
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            //Response text desde backend
            //Acá se carga la respuesta por el alta o  la modificación.
            console.log(xmlHttp.responseText);
            CargarTablaEmpleados();
            CargarFormulario();
        }
    };
};
//# sourceMappingURL=validaciones.js.map