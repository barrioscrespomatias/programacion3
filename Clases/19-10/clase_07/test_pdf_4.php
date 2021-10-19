<?php

require_once __DIR__ . '/vendor/autoload.php';

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);


$mpdf->SetHeader('{PAGENO}{nbpg}');
$mpdf->setFooter('{PAGENO}');


$mpdf->SetWatermarkText('NO COPIAR', 0.1);
//void SetWatermarkText ( [ string $text [, float $alpha ]])

$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'Times New Roman';


$mpdf->WriteHTML('<h1>Hola mundo!</h1>');

$mpdf->WriteText(70, 50, "Texto a 70 horizontal y 50 vertical");


$mpdf->AddPage();

$mpdf->Output('mi_pdf.pdf', 'I');