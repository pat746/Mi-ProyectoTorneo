<?php
require_once '../controllers/PartidoController.php';

$partidoController = new PartidoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'obtenerPartidos':
                $partidoController->obtenerPartidos();
                break;

            case 'obtenerDetallesPartidos':
                $partidoController->obtenerDetallesPartidos($idPartido);
                break;

            case 'obtenerPartido':
                if (isset($_GET['idPartido'])) {
                    $partidoController->obtenerPartidoPorId(intval($_GET['idPartido']));
                } else {
                    echo json_encode(['error' => 'ID del partido no proporcionado.']);
                }
                break;

            default:
                echo json_encode(['error' => 'Acción no válida.']);
                break;
        }
    } else {
        echo json_encode(['error' => 'Acción no proporcionada.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'agregarPartido':
                $partidoController->agregarPartido($_POST);
                break;

            case 'actualizarPartido':
                $partidoController->actualizarPartido($_POST);
                break;

            case 'eliminarPartido':
                if (isset($_POST['idPartido'])) {
                    $partidoController->eliminarPartido(intval($_POST['idPartido']));
                } else {
                    echo json_encode(['error' => 'ID del partido no proporcionado para eliminar.']);
                }
                break;

            default:
                echo json_encode(['error' => 'Acción no válida.']);
                break;
        }
    } else {
        echo json_encode(['error' => 'Acción no proporcionada.']);
    }
}
?>
