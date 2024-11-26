<?php

// Incluimos el controlador
require_once '../controllers/jugador.controllers.php';

$jugadorController = new JugadorController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener todos los jugadores (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerJugadores'])) {
        $jugadorController->obtenerJugadores();
    }

    // Obtener jugador por ID (GET)
    if (isset($_GET['obtenerJugadorPorId']) && isset($_GET['idJugador'])) {
        $idJugador = $_GET['idJugador'];
        $jugadorController->obtenerJugadorPorId($idJugador);
    }
}

// Agregar un jugador (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarJugador'])) {
        $jugadorController->agregarJugador($_POST);
    }

    // Actualizar un jugador (POST)
    if (isset($_POST['actualizarJugador'])) {
        $jugadorController->actualizarJugador($_POST);
    }

    // Eliminar un jugador (POST)
    if (isset($_POST['eliminarJugador'])) {
        $idJugador = $_POST['idJugador'] ?? null;
        if ($idJugador) {
            $jugadorController->eliminarJugador($idJugador);
        } else {
            echo json_encode(['error' => 'ID de jugador no proporcionado.']);
        }
    }
}
?>
