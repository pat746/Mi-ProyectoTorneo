<?php
// Incluimos el controlador de Equipos en Torneo
require_once '../controllers/EquiposTorneoController.php';

$equiposTorneoController = new EquiposTorneoController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener equipos de un torneo (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'obtenerEquiposTorneo' && isset($_GET['ID_Torneo'])) {
        $idTorneo = $_GET['ID_Torneo'];
        $equiposTorneoController->obtenerEquiposTorneo($idTorneo);
    } else {
        echo json_encode(['error' => 'Acción o ID de torneo no proporcionados.']);
    }
}

// Agregar equipo a un torneo (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'agregarEquipoTorneo':
                $params = [
                    'ID_Equipo' => $_POST['ID_Equipo'] ?? null,
                    'ID_Torneo' => $_POST['ID_Torneo'] ?? null,
                ];
                $equiposTorneoController->agregarEquipoTorneo($params);
                break;

            case 'actualizarEquipoTorneo':
                $params = [
                    'ID_Equipo' => $_POST['ID_Equipo'] ?? null,
                    'ID_Torneo' => $_POST['ID_Torneo'] ?? null
                ];
                $equiposTorneoController->actualizarEquipoTorneo($idEquipo,$idTorneo,$params);
                break;

            case 'eliminarEquipoTorneo':
                $idEquipo = $_POST['ID_Equipo'] ?? null;
                $idTorneo = $_POST['ID_Torneo'] ?? null;
                $equiposTorneoController->eliminarEquipoTorneo($idEquipo, $idTorneo);
                break;

            default:
                echo json_encode(['error' => 'Acción no válida.']);
        }
    } else {
        echo json_encode(['error' => 'Acción no proporcionada.']);
    }
}
?>
