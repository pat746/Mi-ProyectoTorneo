<?php

require_once '../models/Posiciones.php';

class PosicionesController {
    private $posicionesModel;

    public function __construct() {
        $this->posicionesModel = new Posiciones();
    }

    // Método para obtener la tabla de posiciones
    public function obtenerTablaPosiciones($idTorneo) {
        $resultados = $this->posicionesModel->generarTablaPosiciones($idTorneo);
        
        if (empty($resultados)) {
            echo json_encode(['error' => 'No se pudieron obtener los datos de la tabla de posiciones.']);
        } else {
            echo json_encode($resultados);
        }
    }
}

// Verificar la acción solicitada
if (isset($_GET['action']) && $_GET['action'] == 'obtenerPosiciones') {
    $idTorneo = $_GET['idTorneo'];
    $posicionesController = new PosicionesController();
    $posicionesController->obtenerTablaPosiciones($idTorneo);
}

?>
