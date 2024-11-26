<?php
require_once '../../models/Campo.php';
$campo = new Campo();
$datosEliminar = [
    "idCampo" => 3
];
$resultado = $campo->delete($datosEliminar);
var_dump($resultado);
