<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Torneo.php';

class TorneoController {
    private $torneoModel;

    public function __construct() {
        $this->torneoModel = new Torneo();
    }

    public function obtenerTorneos() {
        return $this->torneoModel->getAll();
    }

    public function agregarTorneo($params) {
        return $this->torneoModel->add($params);
    }
    public function obtenerTorneoPorId($idTorneo) {
        return $this->torneoModel->getById($idTorneo);
    }
    

    public function actualizarTorneo($params) {
        return $this->torneoModel->update($params);
    }

    public function eliminarTorneo($id) {
        return $this->torneoModel->delete($id);
    }
    

    
}

if (isset($_GET['action'])) {
    $torneoController = new TorneoController();

    switch ($_GET['action']) {
        case 'obtenerTorneos':
            $torneos = $torneoController->obtenerTorneos();
            echo json_encode(empty($torneos) ? ['error' => 'No se encontraron torneos.'] : $torneos);
            break;

        case 'agregarTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'nombreTorneo' => $_POST['nombreTorneo'],
                    'temporada' => $_POST['temporada'],
                    'tipoTorneo' => $_POST['tipoTorneo'],
                    'pais' => $_POST['pais']
                ];
                $success = $torneoController->agregarTorneo($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/torneo/ListarTorneo.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el torneo.']);
                }
            }
            break;

        // Obtener el torneo por ID
        case 'obtenerTorneo':
            if (isset($_GET['ID_Torneo'])) {
                $idTorneo = intval($_GET['ID_Torneo']);
                $torneo = $torneoController->obtenerTorneoPorId($idTorneo);
                
                if ($torneo) {
                    echo json_encode($torneo);
                } else {
                    echo json_encode(['error' => 'Torneo no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de torneo no proporcionado.']);
            }
            break;

        case 'editarTorneo':
            if (isset($_GET['ID_Torneo'])) {
                $idTorneo = intval($_GET['ID_Torneo']); // Asegúrate de convertirlo a número por seguridad
                $torneo = $torneoController->obtenerTorneoPorId($idTorneo); // Llama al controlador para obtener los datos del torneo
                if ($torneo) {
                  // Pasamos los datos del torneo a la vista de edición
                include 'views/editarTorneo.php'; // Asegúrate de que este archivo sea el formulario de edición
                 } else {
                    echo json_encode(['error' => 'Torneo no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de torneo no proporcionado.']);
            }
            break;
                
        case 'actualizarTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idTorneo' => $_POST['ID_Torneo'],
                    'nombreTorneo' => $_POST['Nombre_Torneo'],
                    'temporada' => $_POST['Temporada'],
                    'tipoTorneo' => $_POST['Tipo_Torneo'],
                    'pais' => $_POST['Pais']
                ];
                
                $resultado = $torneoController->actualizarTorneo($params);
                
                // Verificar si el resultado es exitoso
                if ($resultado) {
                    // En lugar de redirigir, responder con un JSON de éxito
                    echo json_encode(['success' => true, 'message' => 'Torneo actualizado correctamente']);
                } else {
                  // Responder con un error si no se pudo actualizar
                    echo json_encode(['success' => false, 'message' => 'Hubo un error al actualizar el torneo.']);
                }
            } else {
                // Si el método no es POST, se responde con un error
                echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            }
            break;
  
        case 'eliminarTorneo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $idTorneo = intval($_POST['id']);
                $success = $torneoController->eliminarTorneo($idTorneo);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/torneo/ListarTorneo.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el torneo.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido o ID no proporcionado.']);
            }
            break;
    }
    
}
?>
