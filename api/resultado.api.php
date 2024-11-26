<?php

require_once '../controllers/ResultadoController.php';

$resultadoController = new ResultadoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerResultados'])) {
        $resultados = $resultadoController->obtenerResultados();
        echo json_encode($resultados);
    }

    if (isset($_GET['obtenerResultadoPorId']) && isset($_GET['idPartido'])) {
        $idPartido = $_GET['idPartido'];
        $resultado = $resultadoController->obtenerResultadoPorId($idPartido);
        echo json_encode($resultado);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarResultado'])) {
        $params = [
            'idPartido' => $_POST['ID_Partido'],
            'golesLocal' => $_POST['Goles_Local'],
            'golesVisitante' => $_POST['Goles_Visitante']
        ];
        $success = $resultadoController->agregarResultado($params);
        echo json_encode(['success' => $success]);
    }

    if (isset($_POST['actualizarResultado'])) {
        $params = [
            'idPartido' => $_POST['ID_Partido'],
            'golesLocal' => $_POST['Goles_Local'],
            'golesVisitante' => $_POST['Goles_Visitante']
        ];
        $success = $resultadoController->actualizarResultado($params);
        echo json_encode(['success' => $success]);
    }

    if (isset($_POST['eliminarResultado'])) {
        $idPartido = $_POST['ID_Partido'];
        $success = $resultadoController->eliminarResultado($idPartido);
        echo json_encode(['success' => $success]);
    }
}

?>
