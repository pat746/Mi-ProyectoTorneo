<?php

// Incluimos el controlador
require_once '../controllers/torneo.controllers.php';

$torneoController = new TorneoController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener todos los torneos (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerTorneos'])) {
        $torneoController->obtenerTorneos();
    }

    // Obtener torneo por ID (GET)
    if (isset($_GET['obtenerTorneoPorId']) && isset($_GET['idTorneo'])) {
        $idTorneo = $_GET['idTorneo'];
        $torneoController->obtenerTorneoPorId($idTorneo);
    }

    // Obtener detalles del torneo (GET)
    //if (isset($_GET['obtenerDetallesTorneo'])) {
       // $torneoController->obtenerDetallesTorneo();
    //}
}

// Agregar un torneo (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarTorneo'])) {
        $torneoController->agregarTorneo($_POST);
    }

    // Actualizar un torneo (POST)
    if (isset($_POST['actualizarTorneo'])) {
        $torneoController->actualizarTorneo($_POST);
    }

    // Eliminar un torneo (POST)
    if (isset($_POST['eliminarTorneo'])) {
        $idTorneo = $_POST['idTorneo'] ?? null;
        if ($idTorneo) {
            $torneoController->eliminarTorneo($idTorneo);
        } else {
            echo json_encode(['error' => 'ID de torneo no proporcionado.']);
        }
    }
}

?>
