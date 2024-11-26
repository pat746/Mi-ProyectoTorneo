<?php
require_once '../../models/Equipo.php';  // Ruta para incluir el modelo

$equipo = new Equipo();

$datosActualizar = [
    "idEquipo" => 4,  // Cambia este ID al que deseas actualizar
    "nombreEquipo" => "Los Chankis",
    "puntos" => 10,
    "partidos_jugados" => 2,
    "partidos_ganados" => 1,
    "partidos_perdidos" => 0,
    "partidos_empatados" => 1
];

$resultado = $equipo->update($datosActualizar);
var_dump($resultado);
?>
