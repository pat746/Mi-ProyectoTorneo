<?php
require_once '../../models/Jugador.php';  // Ruta para incluir el modelo

$jugador = new Jugador();
var_dump($jugador->getAll());
?>
