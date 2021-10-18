<?php
include_once __DIR__ . '/clases/ProductoEnvasado.php';
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : null;



$salida;

$listaProductosEnvasados =  ProductoEnvasado::Traer();
// var_dump($listaProductosEnvasados);


    if ($tabla == 'mostrar') 
    {
        

        ob_start();
        ?>

            <!-- codigoBarra,nombre,origen,precio -->
            <table border="1px" >
                <thead>               
                    <tr>
                        <th><h4>Cod. Barra</h4></th>
                        <th><h4>Nombre</h4></th>
                        <th><h4>Origen</h4></th>
                        <th><h4>Precio</h4></th>
                        <th><h4>Imagen</h4></th>
                    </tr>                         
                </thead>
                <?php foreach ($listaProductosEnvasados as $producto) : ?>
                    <!-- html incrustado en php -->
                    <tbody>
                        <tr>
                            <td class="col-md-6">
                                <span><?php echo $producto->codigoBarra; ?></span>
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->nombre; ?></span>
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->origen; ?></span>
                            </td>
                            <td class="col-md-6">
                                <span><?php echo $producto->precio; ?></span>
                            </td>
                            <td class="col-md-2">
                                <img src="../backend/<?php echo $producto->pathFoto; ?>" alt="img_producto" height="90" width="90">
                            </td>                        
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>

            <?php
            $table = ob_get_clean();
            if (ob_get_level() > 0) {ob_flush();}           
            
            echo $table;
            
    
    }     
    else 
    {
        // Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON.Si el parámetro no es pasado o no contiene el valor mostrar, retornará el array de objetos con formato JSON.
        $salida= $listaProductosEnvasados;
        echo json_encode($salida);
        
    }




