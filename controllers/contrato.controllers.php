<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../models/Contrato.php';

class ContratoController {
    private $contratoModel;

    public function __construct() {
        $this->contratoModel = new Contrato(); // Instanciamos el modelo de Contrato
    }

    // Obtener todos los contratos
    public function obtenerContratos() {
        return $this->contratoModel->getAll();
    }

    // Obtener contrato por ID
    public function obtenerContratoPorId($idContrato) {
        return $this->contratoModel->getById($idContrato);
    }

    // Verificar si el jugador ya está asignado a un contrato
    public function jugadorAsignado($idJugador) {
        return $this->contratoModel->jugadorAsignado($idJugador);
    }

    // Agregar un nuevo contrato
    public function agregarContrato($params) {
        // Verificar si el jugador ya está asignado a otro equipo
        $jugadorAsignado = $this->jugadorAsignado($params['idJugador']);
        if ($jugadorAsignado) {
            return ['success' => false, 'message' => 'El jugador ya está asignado a otro equipo.'];
        }

        // Si no está asignado, se procede a agregar el contrato
        $success = $this->contratoModel->add($params);
        return $success 
            ? ['success' => true, 'message' => 'Contrato agregado correctamente.']
            : ['success' => false, 'message' => 'No se pudo agregar el contrato.'];
    }

    // Actualizar un contrato existente
    public function actualizarContrato($params) {
        $success = $this->contratoModel->update($params);
        return $success
            ? ['success' => true, 'message' => 'Contrato actualizado correctamente.']
            : ['success' => false, 'message' => 'No se pudo actualizar el contrato.'];
    }

    // Eliminar un contrato
    public function eliminarContrato($idContrato) {
        $success = $this->contratoModel->delete($idContrato);
        return $success
            ? ['success' => true, 'message' => 'Contrato eliminado correctamente.']
            : ['success' => false, 'message' => 'No se pudo eliminar el contrato.'];
    }
}

// Lógica para manejar las acciones de los contratos
if (isset($_GET['action'])) {
    $contratoController = new ContratoController();

    switch ($_GET['action']) {
        // Obtener todos los contratos
        case 'obtenerContratos':
            $contratos = $contratoController->obtenerContratos();
            echo json_encode(empty($contratos) ? ['error' => 'No se encontraron contratos.'] : $contratos);
            break;

        // Obtener contrato por ID
        case 'obtenerContrato':
            if (isset($_GET['ID_Contrato'])) {
                $idContrato = $_GET['ID_Contrato'];
                echo json_encode(['message' => 'ID de contrato recibido correctamente', 'id' => $idContrato]);
            } else {
                echo json_encode(['error' => 'ID de contrato no proporcionado']);
            }
            break;

        // Agregar un nuevo contrato
        case 'agregarContrato':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verificar que todos los parámetros estén presentes
                if (isset($_POST['idJugador'], $_POST['idEquipo'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['salario'], $_POST['tipoContrato'])) {
                    // Obtener parámetros enviados para agregar el contrato
                    $params = [
                        'idJugador' => $_POST['idJugador'],
                        'idEquipo' => $_POST['idEquipo'],
                        'fechaInicio' => $_POST['fechaInicio'],
                        'fechaFin' => $_POST['fechaFin'],
                        'salario' => $_POST['salario'],
                        'tipoContrato' => $_POST['tipoContrato']
                    ];
                    $response = $contratoController->agregarContrato($params);
                    
                    if ($response['success']) {
                        // Redirigir si el contrato fue agregado correctamente
                        header("Location: http://localhost/campeonato/public/Contrato/ListarContrato.php");
                        exit();
                    } else {
                        // Mostrar mensaje de error en formato JSON
                        echo json_encode($response);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Faltan parámetros para agregar el contrato.']);
                }
            }
            break;
        

        // Actualizar contrato
        case 'actualizarContrato':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verificar que todos los parámetros estén presentes
                if (isset($_POST['idContrato'], $_POST['idJugador'], $_POST['idEquipo'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['salario'], $_POST['tipoContrato'])) {
                    // Obtener parámetros para actualizar contrato
                    $params = [
                        'idContrato' => $_POST['idContrato'],
                        'idJugador' => $_POST['idJugador'],
                        'idEquipo' => $_POST['idEquipo'],
                        'fechaInicio' => $_POST['fechaInicio'],
                        'fechaFin' => $_POST['fechaFin'],
                        'salario' => $_POST['salario'],
                        'tipoContrato' => $_POST['tipoContrato']
                    ];
                    $response = $contratoController->actualizarContrato($params);
                    echo json_encode($response);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Faltan parámetros para actualizar el contrato.']);
                }
            }
            break;

        // Eliminar contrato
        case 'eliminarContrato':
            if (isset($_POST['idContrato'])) {
                $idContrato = intval($_POST['idContrato']);
                $response = $contratoController->eliminarContrato($idContrato);
                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'ID de contrato no proporcionado.']);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida.']);
            break;
    }
}
?>
