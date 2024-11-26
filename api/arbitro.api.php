<?php

// Incluimos el controlador
require_once '../controllers/arbitro.controllers.php';

$arbitroController = new ArbitroController();

// Verificamos qué tipo de solicitud se hace y qué acción ejecutar

// Obtener todos los árbitros (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['obtenerArbitros'])) {
        $arbitroController->obtenerArbitros();
    }

    // Obtener árbitro por ID (GET)
    if (isset($_GET['obtenerArbitro'])) {
        $id = $_GET['ID_Árbitro'];
        $arbitroController->obtenerArbitroPorId($id);
    }
}

// Agregar un nuevo árbitro (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarArbitro'])) {
    $arbitroController->agregarArbitro($_POST);
}

// Actualizar un árbitro (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizarArbitro'])) {
    $arbitroController->actualizarArbitro($_POST);
}

// Eliminar un árbitro (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminarArbitro'])) {
    $idArbitro = $_POST['idArbitro'];
    $arbitroController->eliminarArbitro($idArbitro);
}
?>
