<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Estadio.php';

class EstadioController {
    private $estadioModel;

    public function __construct() {
        $this->estadioModel = new Estadio();
    }

    public function obtenerEstadios() {
        return $this->estadioModel->getAll();
    }

    public function agregarEstadio($params) {
        return $this->estadioModel->add($params);
    }

    public function obtenerEstadioPorId($idEstadio) {
        return $this->estadioModel->getById($idEstadio);
    }

    public function actualizarEstadio($params) {
        return $this->estadioModel->update($params);
    }

    public function eliminarEstadio($idEstadio) {
        return $this->estadioModel->delete($idEstadio);
    }
}

if (isset($_GET['action'])) {
    $estadioController = new EstadioController();

    switch ($_GET['action']) {
        case 'obtenerEstadios':
            $estadios = $estadioController->obtenerEstadios();
            echo json_encode(empty($estadios) ? ['error' => 'No se encontraron estadios.'] : $estadios);
            break;

        case 'agregarEstadio':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'nombreEstadio' => $_POST['Nombre_Estadio'],
                    'capacidad' => $_POST['capacidad'],
                    'ciudad' => $_POST['ciudad'],
                    'anoInauguracion' => $_POST['Año_Inauguracion']
                ];
                $success = $estadioController->agregarEstadio($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/estadio/ListarEstadio.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el estadio.']);
                }
            }
            break;

        case 'obtenerEstadio':
            if (isset($_GET['ID_Estadio'])) {
                $idEstadio = intval($_GET['ID_Estadio']);
                $estadio = $estadioController->obtenerEstadioPorId($idEstadio);
                
                if ($estadio) {
                    echo json_encode($estadio);
                } else {
                    echo json_encode(['error' => 'Estadio no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de estadio no proporcionado.']);
            }
            break;

        case 'editarEstadio':
            if (isset($_GET['ID_Estadio'])) {
                $idEstadio = intval($_GET['ID_Estadio']);
                $estadio = $estadioController->obtenerEstadioPorId($idEstadio);
                if ($estadio) {
                    include 'views/editarEstadio.php';
                } else {
                    echo json_encode(['error' => 'Estadio no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de estadio no proporcionado.']);
            }
            break;
                
        case 'actualizarEstadio':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idEstadio' => $_POST['ID_Estadio'],
                    'nombreEstadio' => $_POST['Nombre_Estadio'],
                    'capacidad' => $_POST['Capacidad'],
                    'ciudad' => $_POST['Ciudad'],
                    'anoInauguracion' => $_POST['Año_Inauguración']
                ];
                
                $resultado = $estadioController->actualizarEstadio($params);
                echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Estadio actualizado correctamente' : 'Hubo un error al actualizar el estadio.']);
            }
            break;
  
        case 'eliminarEstadio':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $idEstadio = intval($_POST['id']);
                $success = $estadioController->eliminarEstadio($idEstadio);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/estadio/ListarEstadio.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el estadio.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido o ID no proporcionado.']);
            }
            break;
    }
}
?>
