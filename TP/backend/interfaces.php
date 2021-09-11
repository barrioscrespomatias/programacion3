<?php

    interface IArchivo{

        /**
         * Recibe el nombre del archivo de texto donde se guardarán los
         * empleados de la fábrica (empleados.txt). Recorre el array de Empleados y sobreescribe en
         * el archivo de texto, utilizando el método ToString.
         */
        public function GuardarEnArchivo($nombreArchivo);

        /**
         * Recibe el nombre del archivo donde se encuentran los empleados
         * Por cada registro leído, genera un objeto de tipo Empleado y lo agrega a la
         * fábrica (utilizando el método AgregarEmpleado).
         */
        public function TraerDeArchivo($nombreDelArchivo);
    }

?>