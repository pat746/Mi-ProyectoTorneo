<?php

// Incluir el controlador del contrato
require_once '../controllers/ContratoController.php';

$contratoController = new ContratoController();

// Verificamos qué tipo de solicitud HTTP se realiza

// Obtener todos los contratos (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los contratos
    if (isset($_GET['obtenerContratos'])) {
        $contratoController->obtenerContratos();
    }

    // Obtener contrato por ID (GET)
    if (isset($_GET['obtenerContratoPorId']) && isset($_GET['idContrato'])) {
        $idContrato = $_GET['idContrato'];
        $contratoController->obtenerContratoPorId($idContrato);
    }
}

// Agregar un contrato (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar un nuevo contrato
    if (isset($_POST['agregarContrato'])) {
        $contratoController->agregarContrato($_POST);
    }

    // Actualizar un contrato (POST)
    if (isset($_POST['actualizarContrato'])) {
        $contratoController->actualizarContrato($_POST);
    }

    // Eliminar un contrato (POST)
    if (isset($_POST['eliminarContrato'])) {
        $idContrato = $_POST['idContrato'] ?? null;
        if ($idContrato) {
            $contratoController->eliminarContrato($idContrato);
        } else {
            echo json_encode(['error' => 'ID de contrato no proporcionado.']);
        }
    }
}

?>
