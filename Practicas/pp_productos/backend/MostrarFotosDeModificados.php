<?php

// Muestra (en una tabla HTML) todas las imagenes (50px X 50px) de los
// productos envasados registrados en el directorio “./productosModificados/”. Para ello, agregar un método
// estático (en ProductoEnvasado), llamado MostrarModificados.

$mydir = './productosModificados/';
$myfiles = array_diff(scandir($mydir), array('.', '..'));

ob_start();
?>

    <!-- codigoBarra,nombre,origen,precio -->
    <table border="1px" >
        
        <!-- html incrustado en php -->
        <tbody>
            <tr>                   
                <?php foreach ($myfiles as $producto) : ?>
                <td class="col-md-2">
                    <img src="./productosModificados/<?php echo $producto; ?>" alt="img_producto_modificado" height="50" width="50">
                </td>                        
                <?php endforeach; ?>
            </tr>
            </tbody>
    </table>

<?php
$table = ob_get_clean();
if (ob_get_level() > 0) {ob_flush();}

echo $table;