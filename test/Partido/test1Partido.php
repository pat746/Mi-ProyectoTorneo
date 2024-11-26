<?php
require_once '../../models/Partido.php';
$partido = new Partido();

// Obtener todos los partidos
$resultado = $partido->getAll();
var_dump($resultado);
