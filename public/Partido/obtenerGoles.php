<?php
// Obtener el ID del partido desde la URL (o por otra lógica si lo pasas de otra forma)
$partidoID = isset($_GET['id']) ? $_GET['id'] : null;

// Si no se pasa el ID, devolver un error o redirigir
if (!$partidoID) {
    echo 'No se especificó el ID del partido.';
    exit;
}

// URL para obtener los detalles completos del partido desde el controlador
$url = 'http://localhost/campeonato/controllers/partido.controllers.php?action=obtenerDetallesPartidos&ID_Partido=' . $partidoID;

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$partido = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($partido === null || isset($partido['error'])) {
    echo 'Error al obtener los detalles del partido: ' . (isset($partido['error']) ? $partido['error'] : json_last_error_msg());
    exit;
}

// Extraer los goles local y visitante
$golesLocal = isset($partido[0]['GolesLocal']) ? $partido[0]['GolesLocal'] : 'No disponible';
$golesVisitante = isset($partido[0]['GolesVisitante']) ? $partido[0]['GolesVisitante'] : 'No disponible';

// Puedes guardar estos valores en variables globales, en sesión, o simplemente devolverlos
return array('golesLocal' => $golesLocal, 'golesVisitante' => $golesVisitante);
?>
