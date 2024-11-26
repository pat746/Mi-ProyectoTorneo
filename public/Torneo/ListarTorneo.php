<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los torneos desde el controlador
$url = 'http://localhost/campeonato/controllers/torneo.controllers.php?action=obtenerTorneos';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$torneos = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($torneos === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $torneos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Torneos</title>
    <link rel="stylesheet" href="./style.css"> 
</head>
<body>

    <h1>Lista de Torneos</h1>

    <!-- Tabla para mostrar los torneos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Torneo</th>
                <th>Temporada</th>
                <th>Tipo de Torneo</th>
                <th>País</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($torneos)): ?>
                <?php foreach ($torneos as $torneo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($torneo['ID_Torneo']); ?></td>
                        <td><?php echo htmlspecialchars($torneo['Nombre_Torneo']); ?></td>
                        <td><?php echo htmlspecialchars($torneo['Temporada']); ?></td>
                        <td><?php echo htmlspecialchars($torneo['Tipo_Torneo']); ?></td>
                        <td><?php echo htmlspecialchars($torneo['Pais']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/torneo/EditarTorneo.php?id=<?php echo $torneo['ID_Torneo']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarTorneo" action="http://localhost/campeonato/controllers/torneo.controllers.php?action=eliminarTorneo" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $torneo['ID_Torneo']; ?>">
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este torneo?');">
                                Eliminar
                            </button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron torneos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botón para agregar un nuevo torneo -->
    <a href="http://localhost/campeonato/public/torneo/RegistrarTorneo.php" class="btn-add">Agregar Torneo</a>

</body>
</html>

    </div>
</div>  
