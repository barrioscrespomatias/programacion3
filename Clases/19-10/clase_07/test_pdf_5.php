<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . './clases/producto.php';

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);//P-> vertical; L-> horizontal



$mpdf->SetHeader('{DATE j-m-Y}||{PAGENO}{nbpg}');
//alineado izquierda | centro | alineado derecha
$mpdf->setFooter('{DATE Y}|Programacón III|{PAGENO}');


$ArrayDeProductos = Producto::TraerTodosLosProductos();

$grilla = '<table class="table" border="1" align="center">
            <thead>
                <tr>
                    <th>  COD. BARRA </th>
                    <th>  NOMBRE     </th>
                    <th>  FOTO       </th>
                </tr> 
            </thead>';   	

foreach ($ArrayDeProductos as $prod){
    $producto = array();
    $producto["codBarra"] = $prod->GetCodBarra();
    $producto["nombre"] = $prod->GetNombre();

    $grilla .= "<tr>
                    <td>".$prod->GetCodBarra()."</td>
                    <td>".$prod->GetNombre()."</td>
                    <td><img src='archivos/".$prod->GetPathFoto()."' width='100px' height='100px'/></td>
                </tr>";
}

$grilla .= '</table>';

$mpdf->WriteHTML("<h3>Listado de productos</h3>");
$mpdf->WriteHTML("<br>");

$mpdf->WriteHTML($grilla);


$mpdf->Output('mi_pdf.pdf', 'I');