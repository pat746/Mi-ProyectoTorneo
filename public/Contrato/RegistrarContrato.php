<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Contrato</h2>

        <!-- Formulario para agregar un nuevo contrato -->
        <form action="http://localhost/campeonato/controllers/contrato.controllers.php?action=agregarContrato" method="POST">
        
        <!-- Jugador -->
        <div class="form-group">
            <label for="idJugador">Jugador</label>
            <select id="idJugador" name="idJugador" required>
                <option value="">Seleccione un jugador</option>
                <?php 
                    // Cargar los jugadores desde la base de datos
                    include_once '../../models/Jugador.php';
                    $jugador = new Jugador();
                    $jugadores = $jugador->getAll(); // Método que devuelve los jugadores disponibles

                    // Verificar que se hayan cargado los jugadores correctamente
                    if ($jugadores) {
                        // Ordenar los jugadores por nombre de manera alfabética
                        usort($jugadores, function($a, $b) {
                            return strcmp($a['Nombre'], $b['Nombre']);
                        });

                        // Mostrar los jugadores en el formulario
                        foreach ($jugadores as $jugador) {
                            echo "<option value='" . htmlspecialchars($jugador['ID_Jugador']) . "'>" . 
                            htmlspecialchars($jugador['Nombre']) . " " . 
                            htmlspecialchars($jugador['Apellido']) . " (" . 
                            htmlspecialchars($jugador['Posición']) . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No hay jugadores disponibles</option>";
                    }
                ?>
            </select>
        </div>


        <!-- Equipo -->
        <div class="form-group">
            <label for="idEquipo">Equipo</label>
            <select id="idEquipo" name="idEquipo" required>
                <option value="">Seleccione un equipo</option>
                <?php 
                    // Cargar los equipos desde la base de datos
                    include_once '../../models/Equipo.php';
                    $equipo = new Equipo();
                    $equipos = $equipo->getAll(); // Método que devuelve los equipos disponibles

                    // Verificar que se hayan cargado los equipos correctamente
                    if ($equipos) {
                        foreach ($equipos as $equipo) {
                            echo "<option value='" . htmlspecialchars($equipo['ID_Equipo']) . "'>" . htmlspecialchars($equipo['Nombre_Equipo']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay equipos disponibles</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fechaInicio">Fecha de Inicio</label>
            <input 
                type="date" 
                id="fechaInicio" 
                name="fechaInicio" 
                required
                min="<?php 
                    // Establecer la zona horaria correcta
                    date_default_timezone_set('America/Lima'); // Cambia esto por tu zona horaria si es diferente
                    echo date('Y-m-d'); 
                ?>"
                value="<?php 
                    // Establecer la fecha actual para completar el campo
                    echo date('Y-m-d'); 
                ?>">
        </div>



        <!-- Fecha de Fin -->
        <div class="form-group">
            <label for="fechaFin">Fecha de Fin</label>
            <input 
                type="date" 
                id="fechaFin" 
                name="fechaFin" 
                required
                min="<?php echo date('Y-m-d'); ?>"
                max="<?php echo date('Y-m-d', strtotime('+1000 years')); ?>"> <!-- No puede ser más de 1000 años en el futuro -->
        </div>

        <!-- Salario -->
        <div class="form-group">
            <label for="salario">Salario</label>
            <input 
                type="number" 
                id="salario" 
                name="salario" 
                placeholder="Ingrese el salario" 
                min="0" 
                required>
        </div>

        <!-- Tipo de Contrato -->
        <div class="form-group">
            <label for="tipoContrato">Tipo de Contrato</label>
            <select id="tipoContrato" name="tipoContrato" required>
                <option value="Temporal" selected>Temporal</option>
                <!-- Puedes agregar más opciones si lo deseas -->
            </select>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="submit-btn">Registrar Contrato</button>
        </form>

    </div>
</div>
