<?php

require_once __DIR__ . '/vendor/autoload.php';

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P']);//P-> vertical; L-> horizontal

$mpdf->WriteHTML('<h1>Hola mundo!</h1>');

$mpdf->WriteText(70, 50, "Texto a 70 horizontal y 50 vertical");
//void WriteText( float $horizontal, float $vertical, string $text)


$mpdf->Output('mi_pdf.pdf', 'D');//D->down-load; I->in-line; F->file; S->string-return