<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener los contratos desde el controlador
$url = 'http://localhost/campeonato/controllers/contrato.controllers.php?action=obtenerContratos';

// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$contratos = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($contratos === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $contratos = [];
}

// URL para obtener los equipos
$urlEquipos = 'http://localhost/campeonato/controllers/equipo.controllers.php?action=obtenerEquipos';
$responseEquipos = file_get_contents($urlEquipos);
$equipos = json_decode($responseEquipos, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contratos</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Función para actualizar la tabla cuando se cambia el nombre del equipo
            $('#buscarEquipo').keyup(function() {
                var equipoNombre = $(this).val(); // Obtener el nombre del equipo ingresado
                $.ajax({
                    url: 'buscarContratos.php', // El archivo PHP que devolverá los contratos filtrados
                    type: 'GET',
                    data: { equipo: equipoNombre },
                    success: function(data) {
                        // Actualizar el contenido de la tabla con los contratos filtrados
                        $('#tablaContratos').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>

    <h1>Lista de Contratos</h1>

    <!-- Formulario de búsqueda por equipo -->
    <form method="GET" action="">
        <label for="buscarEquipo">Buscar por Nombre de Equipo</label>
        <input type="text" id="buscarEquipo" name="buscarEquipo" placeholder="Ingresa el nombre del equipo" />
    </form>

    <!-- Botón para agregar un nuevo contrato -->
    <a href="http://localhost/campeonato/public/contrato/RegistrarContrato.php" class="btn-add">Agregar Contrato</a>

    <!-- Tabla para mostrar los contratos -->
    <table>
        <thead>
            <tr>
                <th>ID Contrato</th>
                <th>Nombre Jugador</th>
                <th>Nombre Equipo</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Salario</th>
                <th>Tipo de Contrato</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaContratos">
            <?php 
            // Si se ha ingresado un nombre de equipo, filtrar los contratos
            if (isset($_GET['buscarEquipo']) && !empty($_GET['buscarEquipo'])) {
                $equipoNombre = strtolower($_GET['buscarEquipo']); // Convertir a minúsculas para comparación insensible a mayúsculas

                // Filtrar contratos por el nombre del equipo
                $contratos = array_filter($contratos, function($contrato) use ($equipoNombre) {
                    return strpos(strtolower($contrato['Nombre_Equipo']), $equipoNombre) !== false;
                });
            }

            // Verificar si hay contratos después del filtro
            if (empty($contratos)): ?>
                <tr>
                    <td colspan="8">No se encontraron contratos para el equipo seleccionado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($contratos as $contrato): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($contrato['ID_Contrato']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Nombre_Jugador']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Nombre_Equipo']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Fecha_Inicio']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Fecha_Fin']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Salario']); ?></td>
                        <td><?php echo htmlspecialchars($contrato['Tipo_Contrato']); ?></td>
                        <td>
                            <!-- Botón de Editar -->
                            <a href="http://localhost/campeonato/public/contrato/EditarContrato.php?id=<?php echo $contrato['ID_Contrato']; ?>" class="btn-edit">
                                Editar
                            </a>
                            <!-- Botón de Eliminar -->
                            <form id="formEliminarContrato" action="http://localhost/campeonato/controllers/contrato.controllers.php?action=eliminarContrato" method="POST" style="display:inline;">
                                <input type="hidden" name="idContrato" value="<?php echo $contrato['ID_Contrato']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este contrato?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

    </div>
</div>
