<?php
require_once '../../models/Inscripcion.php';
$inscripcion = new Inscripcion();

// ID de la inscripción a eliminar
$datosEliminar = [
    "idInscripcion" => 5 // Asegúrate de que este ID exista en la base de datos
];

$resultado = $inscripcion->delete($datosEliminar);
var_dump($resultado); // Debería mostrar 'bool(true)' si se eliminó correctamente
