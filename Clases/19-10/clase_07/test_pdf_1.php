<?php

require_once __DIR__ . '/vendor/autoload.php';

header('content-type:application/pdf');

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML('<h1>Hola mundo!</h1>');

$mpdf->Output();