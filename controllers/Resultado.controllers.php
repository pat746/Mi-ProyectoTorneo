<?php
error_reporting(E_ALL); // Activa todos los niveles de errores
ini_set('display_errors', 1); // Muestra los errores en pantalla


require_once '../models/ResultadoPartido.php';

class ResultadoController {
    private $resultadoModel;

    public function __construct() {
        $this->resultadoModel = new ResultadoPartido();
    }

    public function obtenerResultados() {
        
        return $this->resultadoModel->getAll();
    }

    public function agregarResultado($params) {
        return $this->resultadoModel->add($params);
    }

    public function obtenerResultadoPorId($idPartido) {
        return $this->resultadoModel->getById($idPartido);
    }

    public function actualizarResultado($params) {
        return $this->resultadoModel->update($params);
    }

    public function eliminarResultado($idPartido) {
        return $this->resultadoModel->delete($idPartido);
    }
}

if (isset($_GET['action'])) {
    $resultadoController = new ResultadoController();

    switch ($_GET['action']) {
        case 'obtenerResultados':

            $resultados = $resultadoController->obtenerResultados();
            
            // Verifica si hay resultados y responde adecuadamente
            if (!empty($resultados)) {
                echo json_encode($resultados); // Devuelve los resultados
            } else {
                echo json_encode([]); // Devuelve un arreglo vacío si no hay resultados
            }
            break;
        
        
        case 'agregarResultado':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idPartido' => $_POST['ID_Partido'],
                    'golesLocal' => $_POST['Goles_Local'] ?? 0,
                    'golesVisitante' => $_POST['Goles_Visitante'] ?? 0,
                ];
                $success = $resultadoController->agregarResultado($params);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/resultado/ListarResultado.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo agregar el resultado.']);
                }
            }
            break;

        case 'obtenerResultado':
            if (isset($_GET['ID_Partido'])) {
                $idPartido = intval($_GET['ID_Partido']);
                $resultado = $resultadoController->obtenerResultadoPorId($idPartido);

                if ($resultado) {
                    echo json_encode($resultado);
                } else {
                    echo json_encode(['error' => 'Resultado no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de partido no proporcionado.']);
            }
            break;

        case 'editarResultado':
            if (isset($_GET['ID_Partido'])) {
                $idPartido = intval($_GET['ID_Partido']);
                $resultado = $resultadoController->obtenerResultadoPorId($idPartido);
                if ($resultado) {
                    include 'views/editarResultado.php';
                } else {
                    echo json_encode(['error' => 'Resultado no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de partido no proporcionado.']);
            }
            break;

        case 'actualizarResultado':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $params = [
                    'idPartido' => $_POST['ID_Partido'],
                    'golesLocal' => $_POST['Goles_Local'],
                    'golesVisitante' => $_POST['Goles_Visitante'],
                ];

                $success = $resultadoController->actualizarResultado($params);
                echo json_encode(['success' => $success, 'message' => $success ? 'Resultado actualizado correctamente' : 'Hubo un error al actualizar el resultado.']);
            }
            break;

        case 'eliminarResultado':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Partido'])) {
                $idPartido = intval($_POST['ID_Partido']);
                $success = $resultadoController->eliminarResultado($idPartido);
                if ($success) {
                    header("Location: http://localhost/campeonato/public/resultado/ListarResultado.php");
                    exit;
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el resultado.']);
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
