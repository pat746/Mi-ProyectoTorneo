<?php
require_once '../../models/Participacion.php';
$participacion = new Participacion();
var_dump($participacion->getAll());
