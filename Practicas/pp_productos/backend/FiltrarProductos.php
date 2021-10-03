<?php
require_once './clases/ProductoEnvasado.php';

// Se recibe por POST el origen, se mostrarán en una tabla (HTML) los productos envasados
// cuyo origen coincidan con el pasado por parámetro.
// Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre
// coincida con el pasado por parámetro.
// Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo
// nombre y origen coincidan con los pasados por parámetro.

$origen = isset($_POST['origen']) ? $_POST['origen'] : null;
$listaProductosEnvasados = ProductoEnvasado::Traer();


ob_start();
?>

    <!-- codigoBarra,nombre,origen,precio -->
    <table border="1px" >
        
        <!-- html incrustado en php -->
        <tbody>
            <tr>                   
                <?php foreach ($listaProductosEnvasados as $producto) : ?>
                    <?php if ($producto->origen == $origen) : ?>
                        <td class="col-md-2">
                            <img src="./productosModificados/<?php echo $producto; ?>" alt="img_producto_modificado" height="50" width="50">
                        </td>                        
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
            </tbody>
    </table>

<?php
$table = ob_get_clean();
if (ob_get_level() > 0) {ob_flush();}

echo $table;
