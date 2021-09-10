<?php

    interface IArchivo{
        function GuardarEnArchivo($nombreArchivo):void;

        function TraerDeArchivo($nombreDelArchivo):void;
    }

?>