<?php
require_once '../../models/Inscripcion.php';
$inscripcion = new Inscripcion();
$datosActualizar = [
    "idInscripcion" => 5, // ID de la inscripción a actualizar
    "idEquipo" => 3,
    "idTorneo" => 2
];
$resultado = $inscripcion->update($datosActualizar);
var_dump($resultado);
