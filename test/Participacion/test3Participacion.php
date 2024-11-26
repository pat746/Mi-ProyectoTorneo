<?php
require_once '../../models/Participacion.php';
$participacion = new Participacion();

$datosActualizar = [
    "idParticipacion" => 6, // Asegúrate de que este ID exista
    "idPartido" => 1,       // Nuevo ID de partido
    "idJugador" => 1,       // Nuevo ID de jugador
    "equipo" => 1,          // Nuevo ID de equipo
    "golesMarcados" => 10    // Nuevo número de goles
];

$resultado = $participacion->update($datosActualizar);
var_dump($resultado);
