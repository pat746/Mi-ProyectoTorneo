<?php

// Incluimos el controlador
require_once '../controllers/estadio.controllers.php';

$estadioController = new EstadioController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener todos los estadios (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerEstadios'])) {
        $estadioController->obtenerEstadios();
    }

    // Obtener estadio por ID (GET)
    if (isset($_GET['obtenerEstadioPorId']) && isset($_GET['idEstadio'])) {
        $idEstadio = $_GET['idEstadio'];
        $estadioController->obtenerEstadioPorId($idEstadio);
    }
}

// Agregar un estadio (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarEstadio'])) {
        $estadioController->agregarEstadio($_POST);
    }

    // Actualizar un estadio (POST)
    if (isset($_POST['actualizarEstadio'])) {
        $estadioController->actualizarEstadio($_POST);
    }

    // Eliminar un estadio (POST)
    if (isset($_POST['eliminarEstadio'])) {
        $idEstadio = $_POST['idEstadio'];
        $estadioController->eliminarEstadio($idEstadio);
    }
}
?>
