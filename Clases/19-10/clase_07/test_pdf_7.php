<?php
require_once __DIR__ . '/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);



$mpdf->SetProtection(array('copy'), 'UserPassword', 'MyPassword');
//El usuario, solo tendrá permiso de copia. El propietario, acceso completo


//permisos
// 'copy'
// 'print'
// 'modify'
// 'annot-forms'
// 'fill-forms'
// 'extract'
// 'assemble'
// 'print-highres'

//logitud de bits de encriptación
// 40
// 128 (default)


$mpdf->WriteHTML('<h1>Documento con protección!!!</h1>');

$mpdf->Output('mi_pdf.pdf', 'I');