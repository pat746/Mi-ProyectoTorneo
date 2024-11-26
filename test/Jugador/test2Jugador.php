<?php
require_once '../../models/Jugador.php';  // Ruta para incluir el modelo

$jugador = new Jugador();

$datosEnviar = [
    "nombreJugador" => "Juan Pérez",
    "posicion" => "Delantero",
    "equipoActual" => 1,  
    "goles" => 0
];

$resultado = $jugador->add($datosEnviar);
var_dump($resultado);
?>
