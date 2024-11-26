<?php
require_once '../../models/Torneo.php';
//actualizar
$torneo = new Torneo();
$params = [
    'nombreTorneo' => 'Copa América 2025',
    'temporada' => '2024',
    'tipoTorneo' => 'Continental',
    'pais' => 'Colombia',
    'idTorneo' => 1 // Cambia el ID por uno válido
];

var_dump($torneo->update($params));
?>
