<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los estadios desde el controlador
$url = 'http://localhost/campeonato/controllers/estadio.controllers.php?action=obtenerEstadios';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$estadios = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($estadios === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $estadios = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estadios</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Lista de Estadios</h1>

    <!-- Tabla para mostrar los estadios -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Estadio</th>
                <th>Capacidad</th>
                <th>Ciudad</th>
                <th>Año de Inauguración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estadios)): ?>
                <?php foreach ($estadios as $estadio): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($estadio['ID_Estadio']); ?></td>
                        <td><?php echo htmlspecialchars($estadio['Nombre_Estadio']); ?></td>
                        <td><?php echo htmlspecialchars($estadio['Capacidad']); ?></td>
                        <td><?php echo htmlspecialchars($estadio['Ciudad']); ?></td>
                        <td><?php echo htmlspecialchars($estadio['Año_Inauguración']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/estadio/EditarEstadio.php?id=<?php echo $estadio['ID_Estadio']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarEstadio" action="http://localhost/campeonato/controllers/estadio.controllers.php?action=eliminarEstadio" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $estadio['ID_Estadio']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este estadio?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron estadios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botón para agregar un nuevo estadio -->
    <a href="http://localhost/campeonato/public/estadio/RegistrarEstadio.php" class="btn-add">Agregar Estadio</a>

</body>
</html>

    </div>
</div>
