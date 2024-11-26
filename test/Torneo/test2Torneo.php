<?php
require_once '../../models/Torneo.php';

$torneo = new Torneo();
$params = [
    'nombreTorneo' => 'Copa Mundial 2024',
    'temporada' => '2024',
    'tipoTorneo' => 'Internacional',
    'pais' => 'Qatar'
];

var_dump($torneo->add($params));
?>
