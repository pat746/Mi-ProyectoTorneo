<?php

// Incluir el controlador de posiciones
require_once '../controllers/posiciones.controllers.php';

// Comprobar si la acción es la que esperamos
if (isset($_GET['action']) && $_GET['action'] == 'obtenerPosiciones') {
    // Crear una instancia del controlador de posiciones
    $posicionesController = new PosicionesController();
    
    // Llamar al método para obtener la tabla de posiciones
    $posicionesController->obtenerTablaPosiciones();
} else {
    // Si no se proporciona la acción correcta
    echo json_encode(['error' => 'Acción no válida.']);
}

?>
