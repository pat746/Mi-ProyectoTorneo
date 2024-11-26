<?php
require_once '../../models/Jugador.php';  

$jugador = new Jugador();

$datosActualizar = [
    "idJugador" => 6,  
    "nombreJugador" => "Juan Pérez",
    "posicion" => "Delantero",
    "equipoActual" => 1,  
    "goles" => 5
];

$resultado = $jugador->update($datosActualizar);
var_dump($resultado);
?>
