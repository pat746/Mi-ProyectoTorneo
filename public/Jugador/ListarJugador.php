<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los jugadores desde el controlador
$url = 'http://localhost/campeonato/controllers/jugador.controllers.php?action=obtenerJugadores';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$jugadores = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($jugadores === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $jugadores = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jugadores</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Lista de Jugadores</h1>
      <!-- Botón para agregar un nuevo jugador -->
      <a href="http://localhost/campeonato/public/jugador/RegistrarJugador.php" class="btn-add">Agregar Jugador</a>

    <!-- Tabla para mostrar los jugadores -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Jugador</th>
                <th>Apellido del Jugador </th>
                <th>Fecha Nacimiento</th>
                <th>Posición</th>
                <th>Nacionalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($jugadores)): ?>
                <?php foreach ($jugadores as $jugador): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($jugador['ID_Jugador']); ?></td>
                        <td><?php echo htmlspecialchars($jugador['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($jugador['Apellido']); ?></td>
                        <td><?php echo htmlspecialchars($jugador['Fecha_Nacimiento']); ?></td>
                        <td><?php echo htmlspecialchars($jugador['Posición']); ?></td>
                        <td><?php echo htmlspecialchars($jugador['Nacionalidad']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/jugador/EditarJugador.php?id=<?php echo $jugador['ID_Jugador']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarJugador" action="http://localhost/campeonato/controllers/jugador.controllers.php?action=eliminarJugador" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $jugador['ID_Jugador']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar a este jugador?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron jugadores.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

  

</body>
</html>

    </div>
</div> 
