<?php 
include '../../includes/nav.php'; 
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Registrar Jugador</h2>

        <!-- Formulario para agregar un nuevo jugador -->
        <form action="http://localhost/campeonato/controllers/jugador.controllers.php?action=agregarJugador" method="POST">
    <div class="form-group">
        <label for="nombreJugador">Nombre del Jugador</label>
        <input 
            type="text" 
            id="nombreJugador" 
            name="Nombre" 
            placeholder="Ingrese el nombre del jugador" 
            maxlength="50" 
            required>
    </div>

    <div class="form-group">
        <label for="apellidoJugador">Apellido del Jugador</label>
        <input 
            type="text" 
            id="apellidoJugador" 
            name="Apellido"  
            placeholder="Ingrese el apellido del jugador" 
            maxlength="50" 
            required>
    </div>

    <div class="form-group">
        <label for="fechaNacimiento">Fecha de Nacimiento</label>
        <input 
            type="date" 
            id="fechaNacimiento" 
            name="Fecha_Nacimiento"  
            required>
    </div>

    <div class="form-group">
    <label for="posicionJugador">Posición</label>
    <select id="posicionJugador" name="Posicion" required>
        <option value="" disabled selected>Seleccione la posición</option>
        <option value="Arquero">Arquero</option>
        <option value="Defensa">Defensa</option>
        <option value="Volante">Volante</option>
        <option value="Delantero">Delantero</option>
    </select>
</div>


    <div class="form-group">
        <label for="nacionalidadJugador">Nacionalidad</label>
        <input 
            type="text" 
            id="nacionalidadJugador" 
            name="Nacionalidad"  
            placeholder="Ingrese la nacionalidad del jugador" 
            maxlength="50" 
            required>
    </div>

    <button type="submit" class="submit-btn">Registrar Jugador</button>
</form>

    </div>
</div>
