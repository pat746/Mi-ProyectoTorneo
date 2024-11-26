<?php
require_once '../../models/Torneo.php';

$torneo = new Torneo();
$idTorneo = 3; 
var_dump($torneo->delete($idTorneo));
?>
