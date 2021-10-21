<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../backend/entidades/empleado.php';
require_once __DIR__ . '/../backend/fabrica.php';

// Agregar un botón/link que permita visualizar el listado de empleados en un archivo .pdf.
// El archivo tendrá:
// *-Encabezado (apellido y nombre del alumno y número de página)
// *-Cuerpo (Título del listado, listado completo de los empleados, con su respectiva foto y sin los botones)
// *-Pie de página (url del sitio web)

// El archivo .pdf contendrá clave, la misma será el número de D.N.I. del usuario logueado.
$password = isset($_SESSION['DNIEmpleado']) ? $_SESSION['DNIEmpleado'] : null;

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);//P-> vertical; L-> horizontal



$mpdf->SetHeader('Barrios Crespo Matías||{PAGENO}{nbpg}');
//alineado izquierda | centro | alineado derecha
$mpdf->setFooter("{DATE Y}|matiasbarrioscrespo.000webhostapp.com|{PAGENO}");



$fabrica = new Fabrica('La fabriquita v.0.3');
$fabrica->SetCantidadMaxima(7);

$fabrica->TraerDeArchivo('../backend/archivos/empleados.txt');
$listaEmpleados = $fabrica->GetEmpleados();

// $grilla = '<table class="table" border="1" align="center">
//             <thead>
//                 <tr>                    
//                     <th>  DNI   </th>
//                     <th>  APELLIDO  </th>
//                     <th>  NOMBRE    </th>                    
//                     <th>  LEGAJO    </th>
//                     <th>  SEXO  </th>
//                     <th>  TURNO </th>
//                     <th>  FOTO  </th>
//                 </tr> 
//             </thead>';   	

// foreach ($listaEmpleados as $prod){
//     // $producto = array();
//     // $producto["codBarra"] = $prod->GetCodBarra();
//     // $producto["nombre"] = $prod->GetNombre();

//     $grilla .= "<tr>
//                     <td>".$prod->GetDni()."</td>
//                     <td>".$prod->GetApellido()."</td>
//                     <td>".$prod->GetNombre()."</td>
//                     <td>".$prod->GetLegajo()."</td>
//                     <td>".$prod->GetSexo()."</td>
//                     <td>".$prod->GetTurno()."</td>
//                     <td><img src='../backend/".$prod->GetPathFoto()."' width='100px' height='100px'/></td>
//                 </tr>";
// }

// $grilla .= '</table>';

$tabla = $fabrica->CargarTablaEmpleados(false); //false corresponde sin botones


$mpdf->WriteHTML("<h3>Lista de empleados</h3>");
$mpdf->WriteHTML("<br>");
$mpdf->WriteHTML($tabla);
// $mpdf->WriteHTML("<a href='/../index.php'>Volver al INDEX</a>");

$mpdf->SetProtection(array(), "$password", "$password");



$mpdf->Output('mi_pdf.pdf', 'I');