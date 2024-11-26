<?php
require_once '../../models/Torneo.php';

$torneo = new Torneo();
var_dump($torneo->getAll());
?>
