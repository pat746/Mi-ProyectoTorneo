<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los torneos (para el select)
$torneosUrl = 'http://localhost/campeonato/controllers/torneo.controllers.php?action=obtenerTorneos';

// Realizar la llamada al controlador y obtener los torneos en formato JSON
$torneosResponse = file_get_contents($torneosUrl);

// Decodificar el JSON de los torneos
$torneos = json_decode($torneosResponse, true);

// Verifica si la decodificación fue exitosa
if ($torneos === null) {
    echo '<p>Error al decodificar el JSON de torneos: ' . json_last_error_msg() . '</p>';
    $torneos = [];
}

// Variable para almacenar los equipos del torneo
$equiposTorneo = [];
$mensaje = '';

// Verificar si un torneo fue seleccionado
if (isset($_GET['ID_Torneo']) && is_numeric($_GET['ID_Torneo'])) {
    // URL para obtener los equipos del torneo seleccionado desde el controlador de EquiposTorneo
    $equiposTorneoUrl = 'http://localhost/campeonato/controllers/equipoTorneo.controllers.php?action=obtenerEquiposTorneo&ID_Torneo=' . $_GET['ID_Torneo'];

    // Realizar la llamada al controlador y obtener los equipos en formato JSON
    $equiposTorneoResponse = file_get_contents($equiposTorneoUrl);

    // Decodificar el JSON de los equipos de ese torneo
    $equiposTorneo = json_decode($equiposTorneoResponse, true);

    // Verificar si la respuesta es un array
    if (!is_array($equiposTorneo)) {
        $mensaje = 'Error al obtener los equipos para este torneo.';
        $equiposTorneo = [];  // Asegurarse de que sea un array vacío
    }

    // Si no hay equipos en el torneo
    if (empty($equiposTorneo)) {
        $mensaje = 'No se encontraron equipos en este torneo.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos por Torneo</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css">
</head>
<body>

    <h1>Equipos por Torneo</h1>

    <!-- Formulario para seleccionar torneo -->
    <form method="GET" action="">
        <label for="ID_Torneo">Selecciona un Torneo:</label>
        <select name="ID_Torneo" id="ID_Torneo" onchange="this.form.submit()">
            <option value="">-- Selecciona un Torneo --</option>
            <?php foreach ($torneos as $torneo): ?>
                <option value="<?php echo $torneo['ID_Torneo']; ?>" <?php echo (isset($_GET['ID_Torneo']) && $_GET['ID_Torneo'] == $torneo['ID_Torneo']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($torneo['Nombre_Torneo']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Mensaje si no hay equipos en el torneo -->
    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <!-- Tabla para mostrar los equipos si hay alguno -->
    <?php if (!empty($equiposTorneo) && is_array($equiposTorneo)): ?>
        <table>
            <thead>
                <tr>
                
                    <th>Nombre del Equipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equiposTorneo as $equipoTorneo): ?>
                    <?php if (is_array($equipoTorneo)): ?>
                        <tr>
                          
                            <td><?php echo htmlspecialchars($equipoTorneo['Nombre_Equipo']); ?></td>
                            <td>
                                <!-- Botón de Eliminar -->
                                <form id="formEliminarEquipoTorneo" action="http://localhost/campeonato/controllers/equipoTorneo.controllers.php?action=eliminarEquipoTorneo" method="POST" style="display:inline;">
                                    <input type="hidden" name="ID_Equipo" value="<?php echo $equipoTorneo['ID_Equipo']; ?>">
                                    <input type="hidden" name="ID_Torneo" value="<?php echo $equipoTorneo['ID_Torneo']; ?>">
                                    <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este equipo de este torneo?');">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Botón para agregar un nuevo equipo al torneo -->
    <?php if (isset($_GET['ID_Torneo']) && !empty($_GET['ID_Torneo'])): ?>
        <a href="http://localhost/campeonato/public/EquipoTorneo/RegistrarEquipoTorneo.php?ID_Torneo=<?php echo htmlspecialchars($_GET['ID_Torneo']); ?>" class="btn-add">Agregar Equipo al Torneo</a>
    <?php else: ?>
        <p>Selecciona un torneo para agregar equipos.</p>
    <?php endif; ?>

</body>
</html>

    </div>
</div>

