<?php
require_once '../../models/Participacion.php';
$participacion = new Participacion();

$datosEnviar = [
    "idPartido" => 1, // Asegúrate de que este ID exista
    "idJugador" => 1, // Asegúrate de que este ID exista
    "equipo" => 1,    // Asegúrate de que este ID exista
    "golesMarcados" => 2
];

$resultado = $participacion->add($datosEnviar);
var_dump($resultado);
