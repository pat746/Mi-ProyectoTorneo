<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Goles.php';

class GolesPartidosController {
    private $golesPartidosModel;

    public function __construct() {
        $this->golesPartidosModel = new Goles();
    }

    public function obtenerGoles() {
        return $this->golesPartidosModel->getAll();
    }

    public function agregarGoles($params) {
        return $this->golesPartidosModel->add($params);
    }

    public function obtenerGolPorId($idGoles) {
        return $this->golesPartidosModel->getById($idGoles);
    }

    public function actualizarGoles($params) {
        return $this->golesPartidosModel->update($params);
    }

    public function eliminarGoles($idGoles) {
        return $this->golesPartidosModel->delete($idGoles);
    }
}

if (isset($_GET['action'])) {
    $golesController = new GolesPartidosController();

    switch ($_GET['action']) {
        case 'obtenerGoles':
            $goles = $golesController->obtenerGoles();
            echo json_encode(empty($goles) ? ['error' => 'No se encontraron registros de goles.'] : $goles);
            break;

        case 'agregarGoles':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idPartido' => $_POST['ID_Partido'],
                    'idJugador' => $_POST['ID_Jugador'],
                    'goles' => $_POST['Goles'] ?? 0,
                ];
                $success = $golesController->agregarGoles($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/goles/ListarGoles.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el registro de goles.']);
                }
            }
            break;

        case 'obtenerGol':
            if (isset($_GET['ID_Goles'])) {
                $idGoles = intval($_GET['ID_Goles']);
                $gol = $golesController->obtenerGolPorId($idGoles);

                if ($gol) {
                    echo json_encode($gol);
                } else {
                    echo json_encode(['error' => 'Registro de goles no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de goles no proporcionado.']);
            }
            break;

        case 'editarGol':
            if (isset($_GET['ID_Goles'])) {
                $idGoles = intval($_GET['ID_Goles']);
                $gol = $golesController->obtenerGolPorId($idGoles);
                if ($gol) {
                    include 'views/editarGol.php';
                } else {
                    echo json_encode(['error' => 'Registro de goles no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de goles no proporcionado.']);
            }
            break;

        case 'actualizarGoles':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idGoles' => $_POST['ID_Goles'],
                    'idPartido' => $_POST['ID_Partido'],
                    'idJugador' => $_POST['ID_Jugador'],
                    'goles' => $_POST['Goles'],
                ];

                $success = $golesController->actualizarGoles($params);
                echo json_encode(['success' => $success, 'message' => $success ? 'Registro actualizado correctamente' : 'Hubo un error al actualizar el registro.']);
            }
            break;

        case 'eliminarGoles':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Goles'])) {
                $idGoles = intval($_POST['ID_Goles']);
                $success = $golesController->eliminarGoles($idGoles);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/goles/ListarGoles.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el registro de goles.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido o ID no proporcionado.']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida.']);
            break;
    }
}
?>
