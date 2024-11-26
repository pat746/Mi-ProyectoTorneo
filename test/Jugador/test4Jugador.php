<?php
require_once '../../models/Jugador.php';  

$jugador = new Jugador();

$datosEliminar = [
    "idJugador" => 6  
];

$resultado = $jugador->delete($datosEliminar);
var_dump($resultado);
?>
