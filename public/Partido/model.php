<!-- Modal para agregar resultado -->
<div id="modalAgregarResultado" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Agregar Resultado</h2>
        <form action="http://localhost/campeonato/controllers/partido.controllers.php?action=agregarResultado" method="POST">
            <input type="hidden" name="ID_Partido" id="modalPartidoID">
            
            <label for="goles_local">Goles Equipo Local:</label>
            <input type="number" name="goles_local" id="goles_local" required>

            <label for="jugador_local">Jugador Equipo Local:</label>
            <select name="jugador_local" id="jugador_local" required>
                <?php foreach ($jugadores as $jugador): ?>
                    <option value="<?php echo $jugador['ID_Jugador']; ?>">
                        <?php echo htmlspecialchars($jugador['Nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="goles_visitante">Goles Equipo Visitante:</label>
            <input type="number" name="goles_visitante" id="goles_visitante" required>

            <label for="jugador_visitante">Jugador Equipo Visitante:</label>
            <select name="jugador_visitante" id="jugador_visitante" required>
                <?php foreach ($jugadores as $jugador): ?>
                    <option value="<?php echo $jugador['ID_Jugador']; ?>">
                        <?php echo htmlspecialchars($jugador['Nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-submit">Guardar Resultado</button>
        </form>
    </div>
</div>

<script>
// Función para abrir el modal
function openModal(partidoID) {
    document.getElementById('modalPartidoID').value = partidoID;
    document.getElementById('modalAgregarResultado').style.display = "block";
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById('modalAgregarResultado').style.display = "none";
}

// Función para alternar la visibilidad del menú
function toggleNav() {
    var nav = document.querySelector('.nav');
    nav.classList.toggle('active');
}
</script>