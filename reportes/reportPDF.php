<?php
require_once '../vendor/autoload.php'; // Asegúrate de ajustar la ruta según tu estructura

use Spipu\Html2Pdf\Html2Pdf;

try {
    // Obtener el ID del torneo desde los parámetros GET, usar torneoId 1 como predeterminado
    $torneoId = isset($_GET['torneoId']) && is_numeric($_GET['torneoId']) ? intval($_GET['torneoId']) : 1;

    // Hacer la solicitud a la API para obtener los datos del torneo
    $url = "http://localhost/campeonato/controllers/torneo.controllers.php?obtenerEstadisticas=true&torneoId=" . $torneoId;
    $json = @file_get_contents($url); // Suprime posibles errores de warning
    $datosTabla = json_decode($json, true);

    // Verificar si los datos de la API son válidos
    if (!$datosTabla) {
        throw new Exception("No se pudieron obtener los datos de la API o la respuesta es inválida.");
    }

    // Construir el HTML para la tabla
    $html = '
    <h1>Estadísticas del Torneo</h1>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Equipo</th>
                <th>Partidos Jugados</th>
                <th>Partidos Ganados</th>
                <th>Partidos Perdidos</th>
                <th>Partidos Empatados</th>
                <th>Puntos</th>
            </tr>
        </thead>
        <tbody>';
    
    // Llenar la tabla con los datos obtenidos de la API
    foreach ($datosTabla as $fila) {
        $html .= '
            <tr>
                <td>' . htmlspecialchars($fila['nombreEquipo']) . '</td>
                <td>' . htmlspecialchars($fila['partidos_jugados']) . '</td>
                <td>' . htmlspecialchars($fila['partidos_ganados']) . '</td>
                <td>' . htmlspecialchars($fila['partidos_perdidos']) . '</td>
                <td>' . htmlspecialchars($fila['partidos_empatados']) . '</td>
                <td>' . htmlspecialchars($fila['puntos']) . '</td>
            </tr>';
    }

    $html .= '
        </tbody>
    </table>';

    // Crear el objeto Html2Pdf
    $html2pdf = new Html2Pdf();
    $html2pdf->writeHTML($html); // Pasar el HTML de la tabla
    $html2pdf->output('estadisticas_torneo.pdf'); // Nombre del archivo de salida

} catch (Exception $e) {
    // Mostrar mensaje de error en caso de que ocurra algún problema
    echo 'Error: ' . $e->getMessage();
}
