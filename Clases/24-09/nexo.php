<?php

$contenido = TraerTodosJSON('./archivos/autos.json');
$listadoDeAutos = json_decode($contenido);

ob_start();    
?>   
    link
           
    <table border="1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <th>Precio</th>
            <th>Color</th>
            <th>Modelo</th>                    
        </tr>
        </thead>
            
        <!-- html incrustado en php -->
        <tbody>        
            <?php foreach ($listadoDeAutos as $auto) : ?>                            
            <tr>
                <td><?php echo $auto->Id; ?></td>
                <td><?php echo $auto->Marca; ?></td>
                <td><?php echo $auto->Precio; ?></td>
                <td><?php echo $auto->Color; ?></td>
                <td><?php echo $auto->Modelo; ?></td>
            </tr>
            <?php endforeach; ?>                      
        </tbody>
    </table> 

<?php
$table = ob_get_clean();
if(ob_get_level() > 0) {ob_flush();}            
echo $table;


function TraerTodosJSON($path)
{      
    $file = fopen($path, "r");            
    $contenido = fread($file, filesize($path));    
    fclose($file);
    return $contenido;
}