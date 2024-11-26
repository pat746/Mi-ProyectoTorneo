<?php
require_once '../../models/Inscripcion.php';
$inscripcion = new Inscripcion();
var_dump($inscripcion->getAll());
