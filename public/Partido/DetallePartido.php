<?php
// Incluir el archivo de navegación
include '../../includes/nav.php';

// Obtener el ID del partido desde la URL
$partidoID = isset($_GET['id']) ? $_GET['id'] : null;

// Si no se pasa el ID, redirigir al listado de partidos
if (!$partidoID) {
    header("Location: ListarPartido.php");
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
    echo '<p>Error al obtener el detalle del partido: ' . (isset($partido['error']) ? $partido['error'] : json_last_error_msg()) . '</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Partido</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css">
</head>
<body>

    <h1>Detalle del Partido</h1>

    <!-- Tabla para mostrar los detalles del partido -->
    <table>
        <thead>
            <tr>
                <th>Campo</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>ID Partido:</strong></td>
                <td><?php echo isset($partido[0]['PartidoID']) ? $partido[0]['PartidoID'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Fecha:</strong></td>
                <td><?php echo isset($partido[0]['FechaPartido']) ? $partido[0]['FechaPartido'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Equipo Local:</strong></td>
                <td><?php echo isset($partido[0]['EquipoLocal']) ? $partido[0]['EquipoLocal'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Equipo Visitante:</strong></td>
                <td><?php echo isset($partido[0]['EquipoVisitante']) ? $partido[0]['EquipoVisitante'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Goles Local:</strong></td>
                <td><?php echo isset($partido[0]['GolesLocal']) ? $partido[0]['GolesLocal'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Goles Visitante:</strong></td>
                <td><?php echo isset($partido[0]['GolesVisitante']) ? $partido[0]['GolesVisitante'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Estadio:</strong></td>
                <td><?php echo isset($partido[0]['Estadio']) ? $partido[0]['Estadio'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Torneo:</strong></td>
                <td><?php echo isset($partido[0]['Torneo']) ? $partido[0]['Torneo'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Temporada:</strong></td>
                <td><?php echo isset($partido[0]['Temporada']) ? $partido[0]['Temporada'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Árbitro:</strong></td>
                <td><?php echo isset($partido[0]['ArbitroNombre']) ? $partido[0]['ArbitroNombre'] : 'No disponible'; ?> <?php echo isset($partido[0]['ArbitroApellido']) ? $partido[0]['ArbitroApellido'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Goleadores:</strong></td>
                <td><?php echo isset($partido[0]['Goleadores']) ? $partido[0]['Goleadores'] : 'No disponible'; ?></td>
            </tr>
            <tr>
                <td><strong>Total Goles:</strong></td>
                <td><?php echo isset($partido[0]['GolesTotales']) ? $partido[0]['GolesTotales'] : 'No disponible'; ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Botón para volver al listado de partidos -->
    <a href="ListarPartido.php" class="btn-back">Volver al Listado de Partidos</a>

</body>
</html>
