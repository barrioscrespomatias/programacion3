<?php
require_once './clases/ProductoEnvasado.php';

// Se recibe por POST el origen, se mostrarán en una tabla (HTML) los productos envasados
// cuyo origen coincidan con el pasado por parámetro.
// Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre
// coincida con el pasado por parámetro.
// Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo
// nombre y origen coincidan con los pasados por parámetro.

$origen = isset($_POST['origen']) ? $_POST['origen'] : null;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;

$filtrados = array();

if($nombre !== "" && $origen !== "")
$filtrados = ProductoEnvasado::FiltrarProductosNombreOrigen($nombre,$origen);
else if($origen !== null && $nombre === "")
$filtrados = ProductoEnvasado::FiltrarProductosOrigen($origen);
else if($nombre !== null && $origen === "")
$filtrados = ProductoEnvasado::FiltrarProductosNombre($nombre);


echo json_encode($filtrados);
            