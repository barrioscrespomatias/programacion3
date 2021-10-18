<?php

interface IParte3
{
    // Existe: retorna true, si la instancia actual está en el array de objetos de tipo ProductoEnvasado que recibe
    // como parámetro (comparar por nombre y origen). Caso contrario retorna false.
    public function Existe($listaProductosEnvasados):bool;

    // GuardarEnArchivo: escribirá en un archivo de texto (./archivos/productos_envasados_borrados.txt) toda
    // la información del producto envasado más la nueva ubicación de la foto. La foto se moverá al
    // subdirectorio “./productosBorrados/”, con el nombre formado por el id punto nombre punto 'borrado'
    // punto hora, minutos y segundos del borrado (Ejemplo: 688.tomate.borrado.105905.jpg)
    public function GuardarEnArchivo();



}