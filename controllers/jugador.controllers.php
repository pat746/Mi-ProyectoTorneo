<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Jugador.php';

class JugadorController {
    private $jugadorModel;

    public function __construct() {
        $this->jugadorModel = new Jugador();
    }

    public function obtenerJugadores() {
        return $this->jugadorModel->getAll();
    }

    public function agregarJugador($params) {
        return $this->jugadorModel->add($params);
    }

    public function obtenerJugadorPorId($idJugador) {
        return $this->jugadorModel->getById($idJugador);
    }

    public function actualizarJugador($params) {
        return $this->jugadorModel->update($params);
    }

    public function eliminarJugador($idJugador) {
        return $this->jugadorModel->delete($idJugador);
    }
    public function obtenerJugadoresPorEquipo($idEquipo) {
        return $this->jugadorModel->getJugadoresPorEquipo($idEquipo);
    }
}

if (isset($_GET['action'])) {
    $jugadorController = new JugadorController();

    switch ($_GET['action']) {
        case 'obtenerJugadores':
            $jugadores = $jugadorController->obtenerJugadores();
            echo json_encode(empty($jugadores) ? ['error' => 'No se encontraron jugadores.'] : $jugadores);
            break;

        case 'agregarJugador':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'nombre' => $_POST['Nombre'],
                    'apellido' => $_POST['Apellido'],
                    'fechaNacimiento' => $_POST['Fecha_Nacimiento'],
                    'posicion' => $_POST['Posicion'],
                    'nacionalidad' => $_POST['Nacionalidad']
                ];
                $success = $jugadorController->agregarJugador($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/jugador/ListarJugador.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el jugador.']);
                }
            }
            break;

        // Obtener el jugador por ID
        case 'obtenerJugador':
            if (isset($_GET['ID_Jugador'])) {
                $idJugador = intval($_GET['ID_Jugador']);
                $jugador = $jugadorController->obtenerJugadorPorId($idJugador);
                
                if ($jugador) {
                    echo json_encode($jugador);
                } else {
                    echo json_encode(['error' => 'Jugador no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de jugador no proporcionado.']);
            }
            break;

        case 'editarJugador':
            if (isset($_GET['ID_Jugador'])) {
                $idJugador = intval($_GET['ID_Jugador']);
                $jugador = $jugadorController->obtenerJugadorPorId($idJugador);
                if ($jugador) {
                    include 'views/editarJugador.php'; // El archivo de edición del jugador
                } else {
                    echo json_encode(['error' => 'Jugador no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de jugador no proporcionado.']);
            }
            break;

        case 'actualizarJugador':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idJugador' => $_POST['ID_Jugador'],
                    'nombre' => $_POST['Nombre'],
                    'apellido' => $_POST['Apellido'],
                    'fechaNacimiento' => $_POST['Fecha_Nacimiento'],
                    'posicion' => $_POST['Posición'],
                    'nacionalidad' => $_POST['Nacionalidad']
                ];
                $resultado = $jugadorController->actualizarJugador($params);
                echo json_encode($resultado ? ['success' => true] : ['success' => false, 'message' => 'Error al actualizar el jugador.']);
            }
            break;

        case 'eliminarJugador':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $idJugador = intval($_POST['id']);
                $success = $jugadorController->eliminarJugador($idJugador);
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

            case 'obtenerJugadoresPorEquipo':
                if (isset($_GET['ID_Equipo'])) {
                    $idEquipo = intval($_GET['ID_Equipo']);
                    $jugadores = $jugadorController->obtenerJugadoresPorEquipo($idEquipo);
                    echo json_encode(empty($jugadores) ? ['error' => 'No se encontraron jugadores para este equipo.'] : $jugadores);
                } else {
                    echo json_encode(['error' => 'ID de equipo no proporcionado.']);
                }
                break;
        }
        
}
?>
