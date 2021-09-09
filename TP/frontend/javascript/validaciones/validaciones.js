"use strict";
var AdministrarValidaciones = function () {
    var dni = ValidarCamposVacios('txtDni');
    var apellido = ValidarCamposVacios('txtApellido');
    var nombre = ValidarCamposVacios('txtNombre');
    var genero = ValidarCombo('cboSexo');
    var legajo = ValidarCamposVacios('txtLegajo');
    var turno = ObtenerTurnoSeleccionado();
    var sueldo = ValidarCamposVacios('txtSueldo');
    // validacion numero de dni
    var dniInt = parseInt(document.getElementById('txtDni').value, 10);
    var rangoDni = ValidarRangoNumerico(dniInt, 1000000, 55000000);
    // validacion sueldo maximo
    var sueldoMaximo = ObtenerSueldoMaximo();
    var sueldoInt = parseInt(document.getElementById('txtSueldo').value, 10);
    var rangoSueldo = ValidarRangoNumerico(sueldoInt, 8000, sueldoMaximo);
    // validando los campos
    var validado = dni != false &&
        apellido != false &&
        nombre != false &&
        genero != false &&
        legajo != false &&
        turno != 'undefined' &&
        sueldo != false &&
        rangoDni !== false &&
        rangoSueldo !== false
        ? 'Todo ok!' : 'Revisar los campos';
    console.log(validado);
    alert(validado);
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
//# sourceMappingURL=validaciones.js.map