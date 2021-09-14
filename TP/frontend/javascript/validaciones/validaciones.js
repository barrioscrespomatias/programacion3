"use strict";
var AdministrarValidaciones = function () {
    var validado = VerificarValidacionesLogin();
    if (validado) {
        console.log('Campos validados correctamente!');
    }
    else {
        console.log('Error al validar los campos');
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
    // validacion numero de dni
    var dniInt = parseInt(document.getElementById('txtDni').value, 10);
    var rangoDni = ValidarRangoNumerico(dniInt, 1000000, 55000000);
    // validacion sueldo maximo
    var sueldoMaximo = ObtenerSueldoMaximo();
    var sueldoInt = parseInt(document.getElementById('txtSueldo').value, 10);
    var rangoSueldo = ValidarRangoNumerico(sueldoInt, 8000, sueldoMaximo);
    // validando los campos
    var validado = dni !== false &&
        apellido !== false &&
        nombre !== false &&
        genero !== false &&
        legajo !== false &&
        turno !== 'undefined' &&
        sueldo !== false &&
        rangoDni !== false &&
        rangoSueldo !== false
        ? true : false;
    return validado;
};
//# sourceMappingURL=validaciones.js.map