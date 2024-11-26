<?php

require_once '../models/Arbitro.php';

class ArbitroController {
    private $arbitroModel;

    public function __construct() {
        $this->arbitroModel = new Arbitro();
    }

    public function obtenerArbitros() {
        return $this->arbitroModel->getAll();
    }

    public function agregarArbitro($params) {
        return $this->arbitroModel->add($params);
    }

    public function obtenerArbitroPorId($idArbitro) {
        return $this->arbitroModel->getById($idArbitro);
    }

    public function actualizarArbitro($params) {
        return $this->arbitroModel->update($params);
    }

    public function eliminarArbitro($id) {
        return $this->arbitroModel->delete($id);
    }
}

if (isset($_GET['action'])) {
    $arbitroController = new ArbitroController();

    switch ($_GET['action']) {
        case 'obtenerArbitros':
            $arbitros = $arbitroController->obtenerArbitros();
            echo json_encode(empty($arbitros) ? ['error' => 'No se encontraron árbitros.'] : $arbitros);
            break;

        case 'agregarArbitro':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'nombre' => $_POST['nombre'],
                    'apellido' => $_POST['apellido'],
                    'nacionalidad' => $_POST['nacionalidad'],
                    'experiencia' => $_POST['experiencia']
                ];
                $success = $arbitroController->agregarArbitro($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/arbitro/ListarArbitro.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el árbitro.']);
                }
            }
            break;

        case 'obtenerArbitro':
            if (isset($_GET['ID_Árbitro'])) {
                $idArbitro = intval($_GET['ID_Árbitro']);
                $arbitro = $arbitroController->obtenerArbitroPorId($idArbitro);
                
                if ($arbitro) {
                    echo json_encode($arbitro);
                } else {
                    echo json_encode(['error' => 'Árbitro no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de árbitro no proporcionado.']);
            }
            break;

        case 'editarArbitro':
            if (isset($_GET['ID_Árbitro'])) {
                $idArbitro = intval($_GET['ID_Árbitro']);
                $arbitro = $arbitroController->obtenerArbitroPorId($idArbitro);
                if ($arbitro) {
                    include 'views/editarArbitro.php';
                } else {
                    echo json_encode(['error' => 'Árbitro no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de árbitro no proporcionado.']);
            }
            break;
                
        case 'actualizarArbitro':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idArbitro' => $_POST['ID_Árbitro'],
                    'nombre' => $_POST['Nombre'],
                    'apellido' => $_POST['Apellido'],
                    'nacionalidad' => $_POST['Nacionalidad'],
                    'experiencia' => $_POST['Experiencia']
                ];
                
                $resultado = $arbitroController->actualizarArbitro($params);
                
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Árbitro actualizado correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Hubo un error al actualizar el árbitro.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            }
            break;
  
        case 'eliminarArbitro':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $idArbitro = intval($_POST['id']);
                $success = $arbitroController->eliminarArbitro($idArbitro);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/arbitro/ListarArbitro.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el árbitro.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido o ID no proporcionado.']);
            }
            break;
    }
}
?>
