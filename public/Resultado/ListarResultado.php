<?php include '../../includes/nav.php'; ?>

<?php
// URL para obtener los resultados desde el controlador
$url = 'http://localhost/campeonato/controllers/Resultado.controllers.php?action=obtenerResultados';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = @file_get_contents($url);

// Verificar si la respuesta es válida
if ($response === FALSE) {
    echo '<p>Error al obtener los datos.</p>';
    $resultados = [];
} else {
    // Decodificar el JSON en un array asociativo
    $resultados = json_decode($response, true);

    // Verificar si la decodificación fue exitosa
    if ($resultados === null) {
        echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
        $resultados = [];
    } else {
        // Verificar si el JSON contiene un error en la respuesta
        if (isset($resultados['error'])) {
            echo '<p>' . htmlspecialchars($resultados['error']) . '</p>';
            $resultados = []; // No procesamos los datos si hay un error
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Resultados</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css">
</head>
<body>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h1>Lista de Resultados</h1>

        <!-- Mostrar un mensaje si no hay resultados -->
        <?php if (empty($resultados)): ?>
            <p>No se encontraron resultados.</p>
        <?php else: ?>
            <!-- Tabla para mostrar los resultados -->
            <table>
                <thead>
                    <tr>
                        <th>ID Partido</th>
                        <th>Goles Local</th>
                        <th>Goles Visitante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $resultado): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($resultado['ID_Partido'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($resultado['Goles_Local'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($resultado['Goles_Visitante'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
