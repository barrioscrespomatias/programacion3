<?php
include_once __DIR__ . '/clases/Televisor.php';
include_once __DIR__ . '/clases/AccesoDatos.php';
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : null;

// (GET) Se mostrará el listado completo de los televisores (obtenidos de la base de datos) en una tabla
// (HTML con cabecera). Invocar al método Traer. Mostrar además, una columna extra con los precios con IVA
// incluido.
// Nota: preparar la tabla (HTML) para que muestre la imagen de la foto (si es que la tiene).

$objSalida = new stdClass();
$objSalida->exito = false;
$objSalida->mensaje = "No se ha podido traer los productos de la base de datos.";

$listaTelevisores =  Televisor::Traer();

   

        ob_start();
        ?>

        <!-- id tipo precio pais foto -->

            <!-- codigoBarra,nombre,origen,precio -->
            <table border="1px" >
                <thead>               
                    <tr>
                        
                        <th><h4>Tipo</h4></th>
                        <th><h4>Precio</h4></th>
                        <th><h4>Pais</h4></th>
                        <th><h4>Foto</h4></th>
                        <th><h4>Precio c/Iva</h4></th>
                    </tr>                         
                </thead>
                <?php foreach ($listaTelevisores as $producto) : ?>
                    <!-- html incrustado en php -->
                    <tbody>
                        <tr>
                            <td class="col-md-6">
                                <span><?php echo $producto->tipo; ?></span>
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->precio; ?></span>
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->paisOrigen; ?></span>
                            </td>                            
                            <td class="col-md-2">                                
                                <img src="<?php echo $producto->path; ?>" alt="img_producto" height="90" width="90">
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->CalcularIVA(); ?></span>
                            </td>                        
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>

            <?php
            $table = ob_get_clean();
            if (ob_get_level() > 0) {ob_flush();}

               
   
echo $table;
