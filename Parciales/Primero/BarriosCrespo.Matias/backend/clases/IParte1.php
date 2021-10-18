<?php

interface IParte1
{
    // Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla productos (id, codigo_barra,
    // nombre, origen, precio, foto), de la base de datos productos_bd. Retorna true, si se pudo agregar, false,
    // caso contrario
    
    /**
     * Retorna booleano
     */
    public function Agregar():bool;

    // Traer: este método estático retorna un array de objetos de tipo ProductoEnvasado, recuperados de la
    // base de datos.

    /**
     * Retorna array de objetos de tipo producto envasado
     */
    public static function Traer():array;


}