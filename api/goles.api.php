<?php

// Incluimos el controlador
require_once '../controllers/golesPartidos.controllers.php';

$golesController = new GolesPartidosController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener todos los goles (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerGoles'])) {
        $golesController->obtenerGoles();
    }

    // Obtener gol por ID (GET)
    if (isset($_GET['obtenerGolPorId']) && isset($_GET['idGol'])) {
        $idGol = $_GET['idGol'];
        $golesController->obtenerGolPorId($idGol);
    }
}

// Agregar gol (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarGol'])) {
        $golesController->agregarGoles($_POST);
    }

    // Actualizar gol (POST)
    if (isset($_POST['actualizarGol'])) {
        $golesController->actualizarGoles($_POST);
    }

    // Eliminar gol (POST)
    if (isset($_POST['eliminarGol'])) {
        $idGol = $_POST['idGol'];
        $golesController->eliminarGoles($idGol);
    }
}
?>
