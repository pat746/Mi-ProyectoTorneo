<?php
require_once '../../models/Equipo.php';  // Ruta para incluir el modelo

$equipo = new Equipo();

$datosEnviar = [
    "nombreEquipo" => "Los Tigres",
    "puntos" => 0,
    "partidos_jugados" => 0,
    "partidos_ganados" => 0,
    "partidos_perdidos" => 0,
    "partidos_empatados" => 0
];

$resultado = $equipo->add($datosEnviar);
var_dump($resultado);
?>
