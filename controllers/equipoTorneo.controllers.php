<?php
require_once '../models/EquipoTorneo.php';

class EquiposTorneoController {
    private $equiposTorneoModel;

    public function __construct() {
        $this->equiposTorneoModel = new EquiposTorneo(); // Instanciamos el modelo de Equipos_Torneo
    }

    // Agregar un equipo al torneo
    public function agregarEquipoTorneo($params) {
        return $this->equiposTorneoModel->add($params);
    }

    // Obtener equipos de un torneo utilizando el procedimiento almacenado
    public function obtenerEquiposTorneo($idTorneo) {
        return $this->equiposTorneoModel->getAllByTorneo($idTorneo);
    }

    // Eliminar un equipo de un torneo
    public function eliminarEquipoTorneo($idEquipo, $idTorneo) {
        return $this->equiposTorneoModel->delete($idEquipo, $idTorneo);
    }

    // Método para actualizar los equipos en el torneo
    public function actualizarEquipoTorneo($idEquipo, $idTorneo, $params) {
        return $this->equiposTorneoModel->update($idEquipo, $idTorneo, $params);
    }
    // Obtener equipos registrados en un torneo
    public function obtenerEquiposRegistrados($idTorneo) {
        return $this->equiposTorneoModel->getEquiposRegistrados($idTorneo);
    }

}

// Lógica para manejar las acciones de los equipos en torneos
if (isset($_GET['action'])) {
    $equiposTorneoController = new EquiposTorneoController();

    switch ($_GET['action']) {
        // Obtener todos los equipos en un torneo usando el procedimiento almacenado
        case 'obtenerEquiposTorneo':
            if (isset($_GET['ID_Torneo']) && is_numeric($_GET['ID_Torneo'])) {
                $idTorneo = intval($_GET['ID_Torneo']);
                // Usamos el método que llama al procedimiento almacenado
                $equipos = $equiposTorneoController->obtenerEquiposTorneo($idTorneo);

                // Comprobamos si la consulta devolvió resultados
                if (empty($equipos)) {
                    echo json_encode(['error' => 'No se encontraron equipos en el torneo.']);
                } else {
                    echo json_encode($equipos);
                }
            } else {
                echo json_encode(['error' => 'ID de torneo no válido o no proporcionado.']);
            }
            break;

        // Agregar equipo a un torneo
        case 'agregarEquipoTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Equipo'], $_POST['ID_Torneo'])) {
                // Validar los parámetros recibidos
                $params = [
                    'idEquipo' => $_POST['ID_Equipo'],
                    'idTorneo' => $_POST['ID_Torneo']
                ];
                $success = $equiposTorneoController->agregarEquipoTorneo($params);

                if ($success) {
                    header("Location: http://localhost/campeonato/public/EquipoTorneo/ListarEquipoTorneo.php?ID_Torneo=" . $_POST['ID_Torneo']);
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el equipo al torneo.']);
                }
            } else {
                echo json_encode(['error' => 'Faltan parámetros necesarios para agregar el equipo al torneo.']);
            }
            break;

        // Eliminar equipo de un torneo
        case 'eliminarEquipoTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Equipo'], $_POST['ID_Torneo'])) {
                $idEquipo = intval($_POST['ID_Equipo']);
                $idTorneo = intval($_POST['ID_Torneo']);
                $success = $equiposTorneoController->eliminarEquipoTorneo($idEquipo, $idTorneo);
        
                if ($success) {
                    // Redirigir incluyendo el ID del torneo
                    header("Location: http://localhost/campeonato/public/equipoTorneo/ListarEquipoTorneo.php?ID_Torneo=$idTorneo");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el equipo del torneo.']);
                }
            } else {
                echo json_encode(['error' => 'ID de equipo o ID de torneo no proporcionados.']);
            }
            break;
        

        // Caso para actualizar el equipo en el torneo
        case 'actualizarEquipoTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Equipo'], $_POST['ID_Torneo'])) {
                // Validar los parámetros recibidos
                $idEquipo = intval($_POST['ID_Equipo']); // Asegúrate de convertir los valores a enteros
                $idTorneo = intval($_POST['ID_Torneo']);
                $params = [
                    'idEquipo' => $idEquipo,
                    'idTorneo' => $idTorneo
                ];

                $success = $equiposTorneoController->actualizarEquipoTorneo($idEquipo, $idTorneo, $params);

                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el equipo en el torneo.']);
                }
            } else {
                echo json_encode(['error' => 'Faltan parámetros necesarios para actualizar el equipo en el torneo.']);
            }
            break;
            // Caso para obtener los equipos registrados
        case 'obtenerEquiposRegistrados':
            if (isset($_GET['ID_Torneo']) && is_numeric($_GET['ID_Torneo'])) {
                $idTorneo = intval($_GET['ID_Torneo']);
                $equipos = $equiposTorneoController->obtenerEquiposRegistrados($idTorneo);

                if (empty($equipos)) {
                    echo json_encode(['error' => 'No se encontraron equipos registrados en el torneo.']);
                } else {
                    echo json_encode($equipos);
                }
            } else {
                echo json_encode(['error' => 'ID de torneo no válido o no proporcionado.']);
            }
            break;

            }
}
?>
