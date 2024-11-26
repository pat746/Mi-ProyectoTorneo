<?php
require_once '../../models/Inscripcion.php';
$inscripcion = new Inscripcion();

$datosEnviar = [
    "idEquipo" => 1, 
    "idTorneo" => 1  
];

$resultado = $inscripcion->add($datosEnviar);
var_dump($resultado);
