<?php
require_once '../../models/Torneo.php';

$torneo = new Torneo();

// Asumiendo que quieres probar con el ID de torneo 1
$idTorneo = 1;  // Puedes cambiar este valor para probar con otros IDs

// Llamamos al método getById pasando el ID del torneo
$torneoInfo = $torneo->getById($idTorneo);

// Mostramos el resultado para verificar
var_dump($torneoInfo);
?>
