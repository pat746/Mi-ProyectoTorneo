<?php

// Incluir el controlador del equipo
require_once '../controllers/EquipoController.php';

$equipoController = new EquipoController();

// Verificamos qué tipo de solicitud HTTP se realiza

// Obtener todos los equipos (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerEquipos'])) {
        $equipoController->obtenerEquipos();
    }

    // Obtener equipo por ID (GET)
    if (isset($_GET['obtenerEquipoPorId']) && isset($_GET['idEquipo'])) {
        $idEquipo = $_GET['idEquipo'];
        $equipoController->obtenerEquipoPorId($idEquipo);
    }
}

// Agregar un equipo (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarEquipo'])) {
        $equipoController->agregarEquipo($_POST);
    }

    // Actualizar un equipo (POST)
    if (isset($_POST['actualizarEquipo'])) {
        $equipoController->actualizarEquipo($_POST);
    }

    // Eliminar un equipo (POST)
    if (isset($_POST['eliminarEquipo'])) {
        $idEquipo = $_POST['idEquipo'] ?? null;
        if ($idEquipo) {
            $equipoController->eliminarEquipo($idEquipo);
        } else {
            echo json_encode(['error' => 'ID de equipo no proporcionado.']);
        }
    }
}
?>
