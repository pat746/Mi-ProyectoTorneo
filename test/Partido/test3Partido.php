<?php
require_once '../../models/Partido.php';
$partido = new Partido();

// Actualizar un partido
$datosActualizar = [
    "idPartido" => 1, 
    "torneo" => 1,
    "equipoLocal" => 1,
    "equipoVisitante" => 2,
    "golesLocal" => 10, 
    "golesVisitante" => 2,
    "fechaPartido" => '2024-09-30 16:00:00',
    "idCampo" => 1
];

$resultado = $partido->update($datosActualizar);
var_dump($resultado);
