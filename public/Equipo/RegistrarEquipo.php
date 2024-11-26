<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Equipo</h2>

        <!-- Formulario para agregar un nuevo equipo -->
        <form action="http://localhost/campeonato/controllers/equipo.controllers.php?action=agregarEquipo" method="POST">
            <!-- Nombre del equipo -->
            <div class="form-group">
                <label for="nombreEquipo">Nombre del Equipo</label>
                <input 
                    type="text" 
                    id="nombreEquipo" 
                    name="nombreEquipo" 
                    placeholder="Ingrese el nombre del equipo" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Ciudad -->
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input 
                    type="text" 
                    id="ciudad" 
                    name="ciudad" 
                    placeholder="Ingrese la ciudad del equipo" 
                    maxlength="50" 
                    required>
            </div>

            <!-- Año de fundación -->
            <div class="form-group">
                <label for="anioFundacion">Año de Fundación</label>
                <input 
                    type="number" 
                    id="anioFundacion" 
                    name="anioFundacion" 
                    placeholder="Ingrese el año de fundación" 
                    min="1900" 
                    max="2100" 
                    required>
            </div>

            <!-- Estadio -->
            <div class="form-group">
                <label for="estadioId">Estadio</label>
                <select id="estadioId" name="estadioId" required>
                    <option value="">Seleccione un estadio</option>
                    <!-- Aquí puedes generar dinámicamente los estadios disponibles desde la base de datos -->
                    <?php 
                        // Ejemplo de cómo cargar estadios desde la base de datos
                        include_once '../../models/Estadio.php';
                        $estadio = new Estadio();
                        $estadios = $estadio->getAll(); // Método que devuelve los estadios disponibles
                        foreach ($estadios as $estadio) {
                            echo "<option value='" . $estadio['ID_Estadio'] . "'>" . $estadio['Nombre_Estadio'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="submit-btn">Registrar Equipo</button>
        </form>
    </div>
</div>
