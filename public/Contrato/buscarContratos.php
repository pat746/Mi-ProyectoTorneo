<?php
// Este archivo se llamará para obtener los contratos filtrados por nombre de equipo

// Incluye las mismas líneas de PHP para obtener contratos
$url = 'http://localhost/campeonato/controllers/contrato.controllers.php?action=obtenerContratos';
$response = file_get_contents($url);
$contratos = json_decode($response, true);

// Filtrar contratos si se ha enviado un nombre de equipo a través de GET
if (isset($_GET['equipo']) && !empty($_GET['equipo'])) {
    $equipoNombre = strtolower($_GET['equipo']); // Convertir a minúsculas para comparación insensible a mayúsculas

    // Filtrar los contratos por el nombre del equipo
    $contratos = array_filter($contratos, function($contrato) use ($equipoNombre) {
        return strpos(strtolower($contrato['Nombre_Equipo']), $equipoNombre) !== false;
    });
}

// Mostrar los contratos en formato de tabla
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
                <a href="http://localhost/campeonato/public/contrato/EditarContrato.php?id=<?php echo $contrato['ID_Contrato']; ?>" class="btn-edit">Editar</a>
                <!-- Botón de Eliminar -->
                <form id="formEliminarContrato" action="http://localhost/campeonato/controllers/contrato.controllers.php?action=eliminarContrato" method="POST" style="display:inline;">
                    <input type="hidden" name="idContrato" value="<?php echo $contrato['ID_Contrato']; ?>">
                    <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este contrato?');">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
