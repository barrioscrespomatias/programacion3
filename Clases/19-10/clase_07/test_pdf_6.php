<?php
require_once __DIR__ . '/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);



$mpdf->SetProtection(array(), 'UserPassword', 'MyPassword');
//void SetProtection ( array $permissions [, string $user_password [, string $owner_password [, integer $length ]]])

//El usuario sólo lo podrá abrir. El propietario, acceso completo


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