<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los equipos desde el controlador
$url = 'http://localhost/campeonato/controllers/equipo.controllers.php?action=obtenerEquipos';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$equipos = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($equipos === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $equipos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Equipos</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Lista de Equipos</h1>

    <!-- Tabla para mostrar los equipos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Equipo</th>
                <th>Ciudad</th>
                <th>Año de Fundación</th>
                <th>Estadio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($equipos)): ?>
                <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($equipo['ID_Equipo']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['Nombre_Equipo']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['Ciudad']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['Año_Fundación']); ?></td>
                        <td><?php echo htmlspecialchars($equipo['Nombre_Estadio']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/equipo/EditarEquipo.php?id=<?php echo $equipo['ID_Equipo']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarEquipo" action="http://localhost/campeonato/controllers/equipo.controllers.php?action=eliminarEquipo" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $equipo['ID_Equipo']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este equipo?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron equipos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botón para agregar un nuevo equipo -->
    <a href="http://localhost/campeonato/public/equipo/RegistrarEquipo.php" class="btn-add">Agregar Equipo</a>

</body>
</html>

    </div>
</div>
