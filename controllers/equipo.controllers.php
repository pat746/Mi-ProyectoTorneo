<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Equipo.php';

class EquipoController {
    private $equipoModel;

    public function __construct() {
        $this->equipoModel = new Equipo(); // Instanciamos el modelo de Equipo
    }

    // Obtener todos los equipos
    public function obtenerEquipos() {
        return $this->equipoModel->getAll();
    }

    // Agregar un nuevo equipo
    public function agregarEquipo($params) {
        return $this->equipoModel->add($params);
    }

    // Obtener un equipo por su ID
    public function obtenerEquipoPorId($idEquipo) {
        return $this->equipoModel->getById($idEquipo);
    }

    // Actualizar un equipo existente
    public function actualizarEquipo($params) {
        return $this->equipoModel->update($params);
    }

    // Eliminar un equipo por ID
    public function eliminarEquipo($id) {
        return $this->equipoModel->delete($id);
    }

    // Obtener todos los estadios
    public function obtenerEstadios() {
        return $this->equipoModel->getAllEstadios();
    }

    // Obtener estadios disponibles
    public function obtenerEstadiosDisponibles() {
        return $this->equipoModel->getEstadiosDisponibles();
    }

    // Obtener equipos por torneo
    public function obtenerEquiposPorTorneo($idTorneo) {
        return $this->equipoModel->getEquiposPorTorneo($idTorneo);
    }
}

// Lógica para manejar las acciones de los equipos
if (isset($_GET['action'])) {
    $equipoController = new EquipoController();

    switch ($_GET['action']) {
        // Obtener todos los equipos
        case 'obtenerEquipos':
            $equipos = $equipoController->obtenerEquipos();
            echo json_encode(empty($equipos) ? ['error' => 'No se encontraron equipos.'] : $equipos);
            break;

        // Agregar un nuevo equipo
        case 'agregarEquipo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtener parámetros enviados para agregar el equipo
                $params = [
                    'nombreEquipo' => $_POST['nombreEquipo'],
                    'ciudad' => $_POST['ciudad'],
                    'anioFundacion' => $_POST['anioFundacion'],
                    'estadioId' => $_POST['estadioId']
                ];
                $success = $equipoController->agregarEquipo($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/equipo/ListarEquipo.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el equipo.']);
                }
            }
            break;

        // Obtener equipo por ID
        case 'obtenerEquipo':
            if (isset($_GET['ID_Equipo'])) {
                $idEquipo = intval($_GET['ID_Equipo']);
                $equipo = $equipoController->obtenerEquipoPorId($idEquipo);
                
                if ($equipo) {
                    echo json_encode($equipo);
                } else {
                    echo json_encode(['error' => 'Equipo no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de equipo no proporcionado.']);
            }
            break;

        // Editar equipo
        case 'editarEquipo':
            if (isset($_GET['ID_Equipo'])) {
                $idEquipo = intval($_GET['ID_Equipo']);
                $equipo = $equipoController->obtenerEquipoPorId($idEquipo);
                if ($equipo) {
                    // Aquí puedes incluir una vista de edición con los datos del equipo
                    include 'views/editarEquipo.php';
                } else {
                    echo json_encode(['error' => 'Equipo no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de equipo no proporcionado.']);
            }
            break;

        // Actualizar equipo
        case 'actualizarEquipo':
            try {
                $params = [
                    'idEquipo' => $_POST['ID_Equipo'],
                    'nombreEquipo' => $_POST['Nombre_Equipo'],
                    'ciudad' => $_POST['Ciudad'],
                    'anioFundacion' => $_POST['Año_Fundación'],
                    'estadioId' => $_POST['Estadio_ID']
                ];
        
                $success = $equipoController->actualizarEquipo($params);
        
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Hubo un error al actualizar el equipo.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
            }
            exit;

        // Eliminar equipo
        case 'eliminarEquipo':
            if (isset($_POST['id'])) { // Usamos $_POST en lugar de $_GET
                $idEquipo = intval($_POST['id']); // Obtenemos el ID del equipo
                $success = $equipoController->eliminarEquipo($idEquipo);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/equipo/ListarEquipo.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el equipo.']);
                }
            } else {
                echo json_encode(['error' => 'ID de equipo no proporcionado.']);
            }
            break;

        // Obtener todos los estadios
        case 'obtenerEstadios':
            $estadios = $equipoController->obtenerEstadios();
            echo json_encode(empty($estadios) ? ['error' => 'No se encontraron estadios.'] : $estadios);
            break;

        // Obtener estadios disponibles 
        case 'obtenerEstadiosDisponibles':
            $estadiosDisponibles = $equipoController->obtenerEstadiosDisponibles();
            echo json_encode(empty($estadiosDisponibles) ? ['error' => 'No se encontraron estadios disponibles.'] : $estadiosDisponibles);
            break;

        // Obtener equipos por torneo
        case 'obtenerEquiposPorTorneo':
            if (isset($_GET['ID_Torneo'])) {
                $idTorneo = $_GET['ID_Torneo'];
                $equiposPorTorneo = $equipoController->obtenerEquiposPorTorneo($idTorneo);
                echo json_encode(empty($equiposPorTorneo) ? ['error' => 'No se encontraron equipos para el torneo.'] : $equiposPorTorneo);
            } else {
                echo json_encode(['error' => 'ID de torneo no proporcionado.']);
            }
            break;

        // Acción no válida
        default:
            echo json_encode(['error' => 'Acción no válida.']);
            break;
    }
}
?>
