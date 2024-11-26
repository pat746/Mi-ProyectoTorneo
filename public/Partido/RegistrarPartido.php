<?php 
include '../../includes/nav.php'; 
?>

<style>
/* Estilos generales para la página */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Contenedor principal */
.content {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Título del formulario */
.content h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 30px;
    color: #333;
}

/* Estilo de los formularios */
form {
    display: flex;
    flex-direction: column;
}

/* Estilos para las etiquetas y campos del formulario */
.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

select, input[type="datetime-local"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

select:disabled {
    background-color: #f9f9f9;
    color: #999;
}

select:focus, input[type="datetime-local"]:focus {
    border-color: #00BF63;
    outline: none;
}

/* Estilo para el contenedor de equipos (ocultado por defecto) */
#equipos-container {
    display: none;
}

/* Botón de envío */
.submit-btn {
    background-color: #00BF63;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #008f45;
}

.submit-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Estilos de los contenedores de selección */
select:disabled, input:disabled {
    background-color: #f1f1f1;
    cursor: not-allowed;
}

form .form-group:last-child {
    margin-bottom: 0;
}


</style>



<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
    <h2>Registrar Partido</h2>

    <!-- Formulario para agregar un nuevo partido -->
    <form action="http://localhost/campeonato/controllers/partido.controllers.php?action=agregarPartido" method="POST">
        <!-- Torneo -->
        <div class="form-group">
            <label for="ID_Torneo">Torneo</label>
            <select id="ID_Torneo" name="ID_Torneo" onchange="cargarEquipos(this.value)" required>
                <option value="">Seleccione un torneo</option>
                <?php 
                    include_once '../../models/Torneo.php';
                    $torneo = new Torneo();
                    $torneos = $torneo->getAll();
                    foreach ($torneos as $torneo) {
                        echo "<option value='" . $torneo['ID_Torneo'] . "'>" . $torneo['Nombre_Torneo'] . "</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Equipos -->
        <div id="equipos-container">
            <div class="form-group">
                <label for="ID_Equipo_Local">Equipo Local</label>
                <select id="ID_Equipo_Local" name="ID_Equipo_Local" onchange="actualizarEquiposDisponibles()" required disabled>
                    <option value="">Seleccione el equipo local</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ID_Equipo_Visitante">Equipo Visitante</label>
                <select id="ID_Equipo_Visitante" name="ID_Equipo_Visitante" onchange="actualizarEquiposDisponibles()" required disabled>
                    <option value="">Seleccione el equipo visitante</option>
                </select>
            </div>
        </div>

        <!-- Fecha y Hora -->
        <div class="form-group">
            <label for="Fecha">Fecha y Hora</label>
            <input 
                type="datetime-local" 
                id="Fecha" 
                name="Fecha" 
                required>
        </div>

        <!-- Árbitro -->
        <div class="form-group">
            <label for="ID_Árbitro">Árbitro</label>
            <select id="ID_Árbitro" name="ID_Árbitro" required>
                <option value="">Seleccione un árbitro</option>
                <?php 
                    include_once '../../models/Arbitro.php';
                    $arbitro = new Arbitro();
                    $arbitros = $arbitro->getAll();
                    foreach ($arbitros as $arbitro) {
                        echo "<option value='" . $arbitro['ID_Árbitro'] . "'>" . $arbitro['Nombre'] . " " . $arbitro['Apellido'] . "</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Estadio -->
        <div class="form-group">
            <label for="ID_Estadio">Estadio</label>
            <select id="ID_Estadio" name="ID_Estadio" required>
                <option value="">Seleccione un estadio</option>
                <?php 
                    include_once '../../models/Estadio.php';
                    $estadio = new Estadio();
                    $estadios = $estadio->getAll();
                    foreach ($estadios as $estadio) {
                        echo "<option value='" . $estadio['ID_Estadio'] . "'>" . $estadio['Nombre_Estadio'] . "</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="submit-btn">Registrar Partido</button>
    </form>
</div>

<script>
function cargarEquipos(ID_Torneo) {
    const equiposContainer = document.getElementById('equipos-container');
    const equipoLocalSelect = document.getElementById('ID_Equipo_Local');
    const equipoVisitanteSelect = document.getElementById('ID_Equipo_Visitante');

    if (!ID_Torneo) {
        equiposContainer.style.display = 'none';
        equipoLocalSelect.disabled = true;
        equipoVisitanteSelect.disabled = true;
        equipoLocalSelect.innerHTML = `<option value="">Seleccione el equipo local</option>`;
        equipoVisitanteSelect.innerHTML = `<option value="">Seleccione el equipo visitante</option>`;
        return;
    }

    equiposContainer.style.display = 'block';

    const urlEquipos = `http://localhost/campeonato/controllers/equipoTorneo.controllers.php?action=obtenerEquiposTorneo&ID_Torneo=${ID_Torneo}`;
    const urlPartidos = `http://localhost/campeonato/controllers/partido.controllers.php?action=obtenerPartidos&ID_Torneo=${ID_Torneo}`;

    // Limpiar las opciones antes de cargar nuevos datos
    equipoLocalSelect.innerHTML = `<option value="">Cargando equipos...</option>`;
    equipoVisitanteSelect.innerHTML = `<option value="">Cargando equipos...</option>`;
    equipoLocalSelect.disabled = true;
    equipoVisitanteSelect.disabled = true;

    fetch(urlPartidos)
    .then(response => response.json())
    .then(partidos => {

        // Obtener equipos ya registrados en partidos
        const equiposRegistrados = partidos.length > 0 
            ? partidos.map(partido => partido.EquipoLocal)
                .concat(partidos.map(partido => partido.EquipoVisitante))
            : [];

        fetch(urlEquipos)
            .then(response => response.json())
            .then(equipos => {
                // Reiniciar las opciones del selector
                equipoLocalSelect.innerHTML = `<option value="">Seleccione el equipo local</option>`;
                equipoVisitanteSelect.innerHTML = `<option value="">Seleccione el equipo visitante</option>`;

                equipos.forEach(equipo => {
                    // Solo agregar equipos no registrados en partidos
                    if (!equiposRegistrados.includes(equipo.Nombre_Equipo)) {
                        const optionHTML = `<option value="${equipo.ID_Equipo}" data-nombre="${equipo.Nombre_Equipo}">${equipo.Nombre_Equipo}</option>`;
                        equipoLocalSelect.innerHTML += optionHTML;
                        equipoVisitanteSelect.innerHTML += optionHTML;
                    }
                });

                // Habilitar selectores
                equipoLocalSelect.disabled = false;
                equipoVisitanteSelect.disabled = false;
            })
            .catch(error => {
                console.error("Error al cargar los equipos del torneo:", error);
                equipoLocalSelect.innerHTML = `<option value="">Error al cargar equipos</option>`;
                equipoVisitanteSelect.innerHTML = `<option value="">Error al cargar equipos</option>`;
            });
    })
    .catch(error => {
        console.error("Error al cargar los partidos del torneo:", error);
        equipoLocalSelect.innerHTML = `<option value="">Error al cargar partidos</option>`;
        equipoVisitanteSelect.innerHTML = `<option value="">Error al cargar partidos</option>`;
    });

}


// Función para actualizar los equipos disponibles
function actualizarEquiposDisponibles() {
    const equipoLocal = document.getElementById('ID_Equipo_Local').value;
    const equipoVisitante = document.getElementById('ID_Equipo_Visitante').value;

    const equipoLocalOptions = document.querySelectorAll('#ID_Equipo_Local option');
    const equipoVisitanteOptions = document.querySelectorAll('#ID_Equipo_Visitante option');

    equipoLocalOptions.forEach(option => {
        option.disabled = equipoVisitante && option.value === equipoVisitante;
    });

    equipoVisitanteOptions.forEach(option => {
        option.disabled = equipoLocal && option.value === equipoLocal;
    });
}
</script>
