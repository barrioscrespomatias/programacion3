<?php
interface IParte2
{


    // ● Agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla televisores (id, tipo, precio,
    // país, foto), de la base de datos productos_bd. Retorna true, si se pudo agregar, false, caso contrario.
    public function Agregar():bool;

    // ● Traer: retorna un array de objetos de tipo Televisor, recuperados de la base de datos.
    public static function Traer():array;

    // ● CalcularIVA: retorna el precio del televisor más el 21%.
    public function CalcularIVA():float;

}