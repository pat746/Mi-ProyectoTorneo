<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los árbitros desde el controlador
$url = 'http://localhost/campeonato/controllers/arbitro.controllers.php?action=obtenerArbitros';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$arbitros = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($arbitros === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $arbitros = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Árbitros</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Lista de Árbitros</h1>

    <!-- Tabla para mostrar los árbitros -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Nacionalidad</th>
                <th>Experiencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($arbitros)): ?>
                <?php foreach ($arbitros as $arbitro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($arbitro['ID_Árbitro']); ?></td>
                        <td><?php echo htmlspecialchars($arbitro['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($arbitro['Apellido']); ?></td>
                        <td><?php echo htmlspecialchars($arbitro['Nacionalidad']); ?></td>
                        <td><?php echo htmlspecialchars($arbitro['Experiencia']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/arbitro/EditarArbitro.php?id=<?php echo $arbitro['ID_Árbitro']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarArbitro" action="http://localhost/campeonato/controllers/arbitro.controllers.php?action=eliminarArbitro" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $arbitro['ID_Árbitro']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este árbitro?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron árbitros.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botón para agregar un nuevo árbitro -->
    <a href="http://localhost/campeonato/public/arbitro/RegistrarArbitro.php" class="btn-add">Agregar Árbitro</a>

</body>
</html>

    </div>
</div>
