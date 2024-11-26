<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Árbitro</h2>

        <!-- Formulario para agregar un nuevo árbitro -->
        <form action="http://localhost/campeonato/controllers/arbitro.controllers.php?action=agregarArbitro" method="POST">
            <!-- Nombre del árbitro -->
            <div class="form-group">
                <label for="nombre">Nombre del Árbitro</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ingrese el nombre del árbitro" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Apellido del árbitro -->
            <div class="form-group">
                <label for="apellido">Apellido del Árbitro</label>
                <input 
                    type="text" 
                    id="Apellido" 
                    name="apellido" 
                    placeholder="Ingrese el apellido del árbitro" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Nacionalidad -->
            <div class="form-group">
                <label for="nacionalidad">Nacionalidad</label>
                <input 
                    type="text" 
                    id="nacionalidad" 
                    name="nacionalidad" 
                    placeholder="Ingrese la nacionalidad" 
                    maxlength="50" 
                    required>
            </div>

            <!-- Experiencia -->
            <div class="form-group">
                <label for="experiencia">Experiencia</label>
                <input 
                    type="number" 
                    id="experiencia" 
                    name="experiencia" 
                    placeholder="Ingrese los años de experiencia" 
                    min="0" 
                    required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="submit-btn">Registrar Árbitro</button>
        </form>
    </div>
</div>
