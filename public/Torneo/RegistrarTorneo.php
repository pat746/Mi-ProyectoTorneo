<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Torneo</h2>

        <!-- Formulario para agregar un nuevo torneo -->
        <form action="http://localhost/campeonato/controllers/torneo.controllers.php?action=agregarTorneo" method="POST">
            <!-- Nombre del torneo -->
            <div class="form-group">
                <label for="nombreTorneo">Nombre del Torneo</label>
                <input 
                    type="text" 
                    id="nombreTorneo" 
                    name="nombreTorneo" 
                    placeholder="Ingrese el nombre del torneo" 
                    maxlength="100" 
                    required>
            </div>

            <!-- Temporada -->
            <div class="form-group">
                <label for="temporada">Temporada</label>
                <input 
                    type="text" 
                    id="temporada" 
                    name="temporada" 
                    placeholder="Ejemplo: 2024-2025" 
                    pattern="\d{4}(-\d{4})?" 
                    title="Ingrese un rango de años, por ejemplo, 2024-2025" 
                    required>
            </div>

            <!-- Tipo de torneo -->
            <div class="form-group">
                <label for="tipoTorneo">Tipo de Torneo</label>
                <select id="tipoTorneo" name="tipoTorneo" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="Continental">Continental</option>
                    <option value="Nacional">Nacional</option>
                    <option value="Local">Local</option>
                </select>
            </div>

            <!-- País -->
            <div class="form-group">
                <label for="pais">País</label>
                <input 
                    type="text" 
                    id="pais" 
                    name="pais" 
                    placeholder="Ingrese el país" 
                    maxlength="50" 
                    required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="submit-btn">Registrar Torneo</button>
        </form>
    </div>
</div>

<!-- Llamar al archivo CSS -->
<head>
    <link rel="stylesheet" href="./style.css">
</head>
