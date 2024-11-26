<?php
require_once '../../models/Partido.php';
$partido = new Partido();

// Agregar un nuevo partido
$datosEnviar = [
    "torneo" => 1, // ID del torneo existente
    "equipoLocal" => 1, // ID del equipo local existente
    "equipoVisitante" => 2, // ID del equipo visitante existente
    "golesLocal" => 10,
    "golesVisitante" => 2,
    "fechaPartido" => '2024-09-30 16:00:00',
    "idCampo" => 1 // ID del campo existente
];


$resultado = $partido->add($datosEnviar);
var_dump($resultado);
