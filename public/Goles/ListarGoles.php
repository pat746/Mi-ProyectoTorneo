<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los goles desde el controlador
$url = 'http://localhost/campeonato/controllers/goles.controllers.php?action=obtenerGoles';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Verifica si la respuesta está vacía o no es válida
if ($response === false) {
    echo '<p>Error al realizar la llamada a la API.</p>';
} else {
    // Verifica si el contenido recibido es un JSON válido
    $goles = json_decode($response, true);

    if ($goles === null) {
        echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
        $goles = []; // Inicializa un array vacío si el JSON es inválido
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Goles</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Lista de Goles</h1>

    <!-- Tabla para mostrar los goles -->
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Partido</th>
                <th>Jugador</th>
                <th>Goles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($goles) && isset($goles[0])): ?>
                <?php foreach ($goles as $gol): ?>
                    <tr>
                        <td><?php echo $gol['ID_Goles']; ?></td>
                        <td><?php echo $gol['ID_Partido']; ?></td>
                        <td><?php echo $gol['Nombre']; ?></td> 
                        <td><?php echo $gol['Goles']; ?></td>
                        <td>
                            <a href="http://localhost/campeonato/public/goles/EditarGol.php?id=<?php echo $gol['ID_Goles']; ?>" class="btn-edit">Editar</a>
                            <form action="http://localhost/campeonato/controllers/goles.controllers.php?action=eliminarGoles" method="POST" style="display:inline;">
                                <input type="hidden" name="ID_Goles" value="<?php echo $gol['ID_Goles']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este gol?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No se encontraron registros de goles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


    <!-- Botón para agregar un nuevo gol -->
    <a href="http://localhost/campeonato/public/goles/RegistrarGol.php" class="btn-add">Agregar Gol</a>

</body>
</html>

    </div>
</div>
