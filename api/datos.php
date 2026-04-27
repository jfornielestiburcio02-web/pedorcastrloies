<?php
require_once 'config.php';

// Supongamos que quieres traer los datos de un nodo llamado "configuracion"
$datos = consultarFirebase("configuracion");

header('Content-Type: application/json');
echo $datos;
