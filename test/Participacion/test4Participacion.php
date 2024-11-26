<?php
require_once '../../models/Participacion.php';
$participacion = new Participacion();

$datosEliminar = [
    "idParticipacion" => 6
];

$resultado = $participacion->delete($datosEliminar);
var_dump($resultado);
