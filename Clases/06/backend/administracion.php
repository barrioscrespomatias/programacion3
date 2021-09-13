<?php

// $file = $_FILES['file'];
$destino = './uploads/'.$_FILES['file']['name'];
$moovedFile = move_uploaded_file($_FILES['file']['tmp_name'],$destino);

$salida = $moovedFile === true ? 'Archivo subido correctamente!' : 'Error';
echo $salida;


?>