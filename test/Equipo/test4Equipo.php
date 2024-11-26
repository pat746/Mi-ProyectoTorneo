<?php
require_once '../../models/Equipo.php';
$equipo = new Equipo();

// Eliminar el equipo con id 5
$resultado = $equipo->delete(7);
var_dump($resultado); // Debería devolver true si la eliminación fue exitosa

?>
