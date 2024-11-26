<?php
require_once '../../models/Campo.php';
$campo = new Campo();
$datosActualizar = [
    "idCampo" => 1,
    "nombreCampo" => "Campo B",
    "ubicacion" => "Zona Norte"
];
$resultado = $campo->update($datosActualizar);
var_dump($resultado);
