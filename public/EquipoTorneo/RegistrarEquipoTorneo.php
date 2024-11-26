<?php
include '../../includes/nav.php';

// Obtener el ID del torneo desde la URL
$ID_Torneo = isset($_GET['ID_Torneo']) ? intval($_GET['ID_Torneo']) : 0;

if ($ID_Torneo <= 0) {
    echo "<p>Error: ID del torneo no válido.</p>";
    exit;
}

require_once '../../models/Conexion.php';
$conexion = new Conexion();
$pdo = $conexion->getConexion();

// Consulta para obtener los equipos disponibles (no asociados al torneo)
$query = "
    SELECT e.ID_Equipo, e.Nombre_Equipo
    FROM Equipos e
    WHERE e.ID_Equipo NOT IN (
        SELECT et.ID_Equipo
        FROM equipos_torneo et
        WHERE et.ID_Torneo = :ID_Torneo
    )
";
$cmd = $pdo->prepare($query);
$cmd->bindParam(':ID_Torneo', $ID_Torneo, PDO::PARAM_INT);
$cmd->execute();
$equiposDisponibles = $cmd->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Agregar Equipo al Torneo</title>
            <link rel="stylesheet" href="../../css/estiloGlobal.css">
        </head>
        <body>

        <h1>Agregar Equipo al Torneo</h1>
        <p>Torneo ID: <?php echo htmlspecialchars($ID_Torneo); ?></p>

        <!-- Validar si hay equipos disponibles -->
        <?php if (empty($equiposDisponibles)): ?>
            <p>No hay equipos disponibles para agregar a este torneo.</p>
            <a href="http://localhost/campeonato/public/EquipoTorneo/ListarEquipoTorneo.php?ID_Torneo=<?php echo htmlspecialchars($ID_Torneo); ?>" class="btn-secondary">Volver a la Lista de Equipos</a>
        <?php else: ?>

            <!-- Formulario para agregar un equipo -->
            <form action="http://localhost/campeonato/controllers/equipoTorneo.controllers.php?action=agregarEquipoTorneo" method="POST">

                <input type="hidden" name="ID_Torneo" value="<?php echo htmlspecialchars($ID_Torneo); ?>">

                <div class="form-group">
                    <label for="ID_Equipo">Selecciona el Equipo:</label>
                    <select id="ID_Equipo" name="ID_Equipo" class="form-control" required>
                        <option value="">-- Selecciona un equipo --</option>
                        <?php foreach ($equiposDisponibles as $equipo): ?>
                            <option value="<?php echo htmlspecialchars($equipo['ID_Equipo']); ?>">
                                <?php echo htmlspecialchars($equipo['Nombre_Equipo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Guardar Equipo</button>
            </form>

            <br>
            <!-- Enlace para regresar a la lista de equipos del torneo -->
            <a href="http://localhost/campeonato/public/EquipoTorneo/ListarEquipoTorneo.php?ID_Torneo=<?php echo htmlspecialchars($ID_Torneo); ?>" class="btn-secondary">Volver a la Lista de Equipos</a>
        <?php endif; ?>

        </body>
        </html>
    </div>
</div>
