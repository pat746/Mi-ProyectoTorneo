<?php
require_once '../../models/Equipo.php';
$equipo = new Equipo();
var_dump($equipo->getAll());
