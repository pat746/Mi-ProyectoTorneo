<?php
require_once '../../models/Partido.php';
$partido = new Partido();

// Eliminar un partido
$datosEliminar = [
    "idPartido" => 6 // ID del partido a eliminar
];

$resultado = $partido->delete($datosEliminar['idPartido']); // Llama al método de eliminación
var_dump($resultado); // Muestra el resultado de la operación de eliminación
?>
