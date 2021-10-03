<?php
    interface IParte2
    {
        /** 
         * Retorna booleano
         * Eliminar: este método estático, elimina de la base de datos el registro coincidente con el id recibido cómo
         *  parámetro. Retorna true, si se pudo eliminar, false, caso contrario.
             
            */
        public static function Eliminar($idEliminar):bool;

        
           
        
        /**
         *  Modifica en la base de datos el registro coincidente con la instancia actual (comparar por id).
         *  Retorna true, si se pudo modificar, false, caso contrario.
         * 
         */
        public function Modificar():bool;

    }
    
