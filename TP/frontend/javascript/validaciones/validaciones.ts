
const AdministrarValidaciones = () => {
    const dni = ValidarCamposVacios('txtDni');
    const apellido = ValidarCamposVacios('txtApellido');
    const nombre = ValidarCamposVacios('txtNombre');
    const genero = ValidarCombo('cboSexo');
    const legajo = ValidarCamposVacios('txtLegajo');
    const turno = ObtenerTurnoSeleccionado();
    const sueldo = ValidarCamposVacios('txtSueldo');

    // validacion numero de dni
    
    const dniInt:number = parseInt((<HTMLInputElement>document.getElementById('txtDni')).value,10);
    const rangoDni = ValidarRangoNumerico(dniInt,1000000,55000000);

    
    // validacion sueldo maximo
    const sueldoMaximo = ObtenerSueldoMaximo();
    const sueldoInt:number = parseInt((<HTMLInputElement>document.getElementById('txtSueldo')).value,10);
    const rangoSueldo = ValidarRangoNumerico(sueldoInt,8000,sueldoMaximo);

    // validando los campos
    const validado =
        dni != false &&
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