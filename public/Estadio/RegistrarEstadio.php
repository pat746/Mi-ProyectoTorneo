<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Estadio</h2>

        <!-- Formulario para agregar un nuevo estadio -->
        <form action="http://localhost/campeonato/controllers/estadio.controllers.php?action=agregarEstadio" method="POST">
            <!-- Nombre del estadio -->
            <div class="form-group">
                <label for="Nombre_Estadio">Nombre del Estadio</label>
                <input 
                    type="text" 
                    id="Nombre_Estadio" 
                    name="Nombre_Estadio" 
                    placeholder="Ingrese el nombre del estadio" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Capacidad -->
            <div class="form-group">
                <label for="capacidad">Capacidad</label>
                <input 
                    type="number" 
                    id="capacidad" 
                    name="capacidad" 
                    placeholder="Ingrese la capacidad del estadio" 
                    min="1" 
                    required>
            </div>

            <!-- Ciudad -->
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input 
                    type="text" 
                    id="ciudad" 
                    name="ciudad" 
                    placeholder="Ingrese la ciudad del estadio" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Año de Inauguración -->
            <div class="form-group">
                <label for="Año_Inauguracion">Año de Inauguración</label>
                <input 
                    type="number" 
                    id="Año_Inauguracion" 
                    name="Año_Inauguracion" 
                    placeholder="Ingrese el año de inauguración" 
                    min="1900" 
                    max="2100" 
                    required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="submit-btn">Registrar Estadio</button>
        </form>
    </div>
</div>
