<?php
require_once '../../models/Campo.php';
$campo = new Campo();
$datosEnviar = [
    "nombreCampo" => "Campo A",
    "ubicacion" => "Zona Centro"
];
$resultado = $campo->add($datosEnviar);
var_dump($resultado);
