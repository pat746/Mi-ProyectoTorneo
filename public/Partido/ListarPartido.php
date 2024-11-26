<?php include '../../includes/nav.php';


?>

<head>
    <link rel="stylesheet" href="estilo.css">
</head>
<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

        <?php
        // URL para obtener los torneos desde el controlador
        $torneosUrl = 'http://localhost/campeonato/controllers/torneo.controllers.php?action=obtenerTorneos';

        // Realizar la llamada al controlador y obtener los datos en formato JSON
        $torneosResponse = file_get_contents($torneosUrl);

        // Comprobamos si la respuesta es válida
        if ($torneosResponse === false) {
            echo '<p>Error al obtener los torneos.</p>';
            $torneos = [];
        } else {
            // Decodificar el JSON en un array asociativo
            $torneos = json_decode($torneosResponse, true);

            // Verifica si la decodificación fue exitosa
            if ($torneos === null) {
                echo '<p>Error al decodificar el JSON de torneos: ' . json_last_error_msg() . '</p>';
                $torneos = [];
            }
        }

        // Verificar si se ha seleccionado un torneo y obtener los partidos correspondientes
        $partidos = [];
        if (isset($_GET['ID_Torneo']) && is_numeric($_GET['ID_Torneo'])) {
            $partidosUrl = 'http://localhost/campeonato/controllers/partido.controllers.php?action=obtenerPartidosPorTorneo&ID_Torneo=' . $_GET['ID_Torneo'];
            $partidosResponse = file_get_contents($partidosUrl);
            
            if ($partidosResponse === false) {
                echo '<p>Error al obtener los partidos.</p>';
            } else {

                // Intentar decodificar la respuesta de los partidos
                $partidos = json_decode($partidosResponse, true);
                
                $golesArrray = [];
                for ($i=0; $i < count($partidos); $i++) { 
                    $golesUrl = 'http://localhost/campeonato/controllers/partido.controllers.php?action=obtenerDetallesPartidos&ID_Partido=' . $partidos[$i]['ID_Partido'];
    
                    $golesresponse = file_get_contents($golesUrl);
    
                    $goles = json_decode($golesresponse, true);
                    
                    $golesArrray[$i] = $goles;

                }                

                // Verificar si la respuesta decodificada no es un array
                if ($partidos === null) {
                    echo '<p>Error al decodificar el JSON de partidos: ' . json_last_error_msg() . '</p>';
                }
            }
        }

        // Si no se obtuvieron partidos, asegurarse de que la variable $partidos sea un array vacío
        if (!is_array($partidos)) {
            $partidos = [];
        }

        // URL para obtener los equipos
        $equiposUrl = 'http://localhost/campeonato/controllers/equipo.controllers.php?action=obtenerEquipos';
        $equiposResponse = file_get_contents($equiposUrl);
        $equipos = json_decode($equiposResponse, true);

        // Crear un array de equipos con los ID como claves y los nombres como valores
        $equiposArray = [];
        foreach ($equipos as $equipo) {
            $equiposArray[$equipo['ID_Equipo']] = $equipo['Nombre_Equipo'];
        }

        // URL para obtener los árbitros
        $arbitrosUrl = 'http://localhost/campeonato/controllers/arbitro.controllers.php?action=obtenerArbitros';
        $arbitrosResponse = file_get_contents($arbitrosUrl);
        $arbitros = json_decode($arbitrosResponse, true);

        // Crear un array de árbitros con los ID como claves y los nombres como valores
        $arbitrosArray = [];
        foreach ($arbitros as $arbitro) {
            $arbitrosArray[$arbitro['ID_Árbitro']] = $arbitro['Nombre'];
        }

        // URL para obtener los estadios
        $estadiosUrl = 'http://localhost/campeonato/controllers/estadio.controllers.php?action=obtenerEstadios';
        $estadiosResponse = file_get_contents($estadiosUrl);
        $estadios = json_decode($estadiosResponse, true);

        // Crear un array de estadios con los ID como claves y los nombres como valores
        $estadiosArray = [];
        foreach ($estadios as $estadio) {
            $estadiosArray[$estadio['ID_Estadio']] = $estadio['Nombre_Estadio'];
        }

        // Obtener jugadores de los equipos correspondientes (local y visitante)
        $jugadoresArray = [];

        if (!empty($partidos)) {
            if (!$partidos['error']) {
                $jugadoresArray = []; // Inicializamos el array principal

                for ($i = 0; $i < count($partidos); $i++) {
                    $equipoLocal = $partidos[$i]['ID_Equipo_Local'];
                    $equipoVisitante = $partidos[$i]['ID_Equipo_Visitante'];

                    // Obtener jugadores del equipo local
                    $jugadoresLocalUrl = 'http://localhost/campeonato/controllers/jugador.controllers.php?action=obtenerJugadoresPorEquipo&ID_Equipo=' . $equipoLocal;
                    $jugadoresLocalResponse = file_get_contents($jugadoresLocalUrl);
                    $jugadoresLocal = json_decode($jugadoresLocalResponse, true) ?: [];

                    // Obtener jugadores del equipo visitante
                    $jugadoresVisitanteUrl = 'http://localhost/campeonato/controllers/jugador.controllers.php?action=obtenerJugadoresPorEquipo&ID_Equipo=' . $equipoVisitante;
                    $jugadoresVisitanteResponse = file_get_contents($jugadoresVisitanteUrl);
                    $jugadoresVisitante = json_decode($jugadoresVisitanteResponse, true) ?: [];

                    // Agregar jugadores de los equipos a los arrays de forma independiente
                    if ($jugadoresLocal) {
                        $jugadoresArray['equipo_local' . ($i + 1)] = [
                            $i + 1 => $equipoLocal,
                            $equipoLocal => $jugadoresLocal,
                        ];
                    }

                    if ($jugadoresVisitante) {
                        $jugadoresArray['equipo_visitante' . ($i + 1)] = [
                            $i + 1 => $equipoVisitante,
                            $equipoVisitante => $jugadoresVisitante,
                        ];
                    }
                }
            }
        }

        ?>

        <h1>Partidos por Torneo</h1>

        <!-- Botón para registrar un nuevo partido -->
        <div style="margin-bottom: 20px;">
            <a href="http://localhost/campeonato/public/partido/RegistrarPartido.php" class="btn-add">
                Registrar Nuevo Partido
            </a>
        </div>

        <!-- Formulario para seleccionar torneo -->
        <form method="GET" action="">
            <label for="ID_Torneo">Selecciona un Torneo:</label>
            <select name="ID_Torneo" id="ID_Torneo" onchange="this.form.submit()">
                <option value="">-- Selecciona un Torneo --</option>
                <?php foreach ($torneos as $torneo): ?>
                    <option value="<?php echo $torneo['ID_Torneo']; ?>" <?php echo (isset($_GET['ID_Torneo']) && $_GET['ID_Torneo'] == $torneo['ID_Torneo']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($torneo['Nombre_Torneo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Mensaje si no hay partidos en el torneo seleccionado -->
        <?php if (empty($partidos) || $partidos['error']): ?>
            <p>No hay partidos registrados para este torneo.</p>
        <?php else: ?>
            <!-- Mostrar partidos -->
            <div class="fixture-container">
                <?php 
                $contador = 1; 
                $goles = 0;
                ?>
                <?php foreach ($partidos as $partido): ?>
                    <div class="partido">
                        <div class="info">
                            <span class="fecha"><?php echo htmlspecialchars($partido['Fecha']); ?></span>
                        </div>
                        <div class="equipos">
                            <span class="equipo"><?php echo htmlspecialchars($equiposArray[$partido['ID_Equipo_Local']]); ?></span>
                            <span class="resultado">vs</span>
                            <span class="equipo"><?php echo htmlspecialchars($equiposArray[$partido['ID_Equipo_Visitante']]); ?></span>
                        </div>
                        <div class="detalles">
                            <span class="arbitro">Árbitro: <?php echo htmlspecialchars($arbitrosArray[$partido['ID_Árbitro']]); ?></span>
                            <p><?php echo $golesArrray[$goles][$goles]['GolesLocal'] ? $golesArrray[$goles][$goles]['GolesLocal'] : 0 ?></p>
                            <p><?php echo $golesArrray[$goles][$goles]['GolesVisitante']? $golesArrray[$goles][$goles]['GolesVisitante'] : 0 ?></p>
                            <span class="estadio">Estadio: <?php echo htmlspecialchars($estadiosArray[$partido['ID_Estadio']]); ?></span>

                        </div>

                        <div class="acciones">
                            <a href="http://localhost/campeonato/public/partido/DetallePartido.php?id=<?php echo $partido['ID_Partido']; ?>" class="btn-view">Ver Detalle</a>
                            <form action="http://localhost/campeonato/controllers/partido.controllers.php?action=eliminarPartido" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $partido['ID_Partido']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este partido?');">Eliminar</button>
                            </form>
                            <!-- Botón para abrir el modal -->
                            <a href="javascript:void(0);" class="btn-add-result" onclick="openModal(<?php echo $partido['ID_Partido']; ?>, <?php echo  $contador?>)">Añadir Resultado</a>
                            <?php 
                                $contador++; 
                                $goles++;
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal para añadir resultado -->
    <div id="modalAgregarResultado" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Agregar Resultado</h2>
            <form action="http://localhost/campeonato/controllers/partido.controllers.php?action=agregarResultado" method="POST">
                <input type="hidden" id="partidoId" name="partidoId">
                <label for="golesLocal">Goles Local:</label>
                <input type="number" id="golesLocal" name="golesLocal" required><br><br>
                <label for="golesVisitante">Goles Visitante:</label>
                <input type="number" id="golesVisitante" name="golesVisitante" required><br><br>
                <label for="jugadorLocal">Jugador Local:</label>
                <select id="jugadorLocal" name="jugadorLocal">
                    <!-- Se llenará dinámicamente con los jugadores del equipo local -->
                </select><br><br>
                <label for="jugadorVisitante">Jugador Visitante:</label>
                <select id="jugadorVisitante" name="jugadorVisitante">
                    <!-- Se llenará dinámicamente con los jugadores del equipo visitante -->
                </select><br><br>

                <button type="submit">Guardar Resultado</button>
            </form>
        </div>
    </div>

    <script>
        // Función para abrir el modal
        function openModal(partidoId, valor) {
            // Establecer el ID del partido en el campo oculto
            document.getElementById('partidoId').value = partidoId;

             // Construir claves dinámicas
            var claveLocal = `equipo_local${valor}`;
            var claveVisitante = `equipo_visitante${valor}`;

            var jugadoresArray = <?php echo json_encode($jugadoresArray, JSON_PRETTY_PRINT); ?>;

            // Obtener los jugadores del equipo local y visitante
            var jugadoresLocal = jugadoresArray[claveLocal];
            var jugadoresVisitante = jugadoresArray[claveVisitante];
        

            
            // Llenar los selectores de jugadores
            var selectorLocal = document.getElementById('jugadorLocal');
            var selectorVisitante = document.getElementById('jugadorVisitante');

            // Limpiar opciones anteriores
            selectorLocal.innerHTML = '';
            selectorVisitante.innerHTML = '';

            var optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.textContent = 'Seleccionar Jugador';
            selectorLocal.appendChild(optionDefault);
            selectorVisitante.appendChild(optionDefault.cloneNode(true));

            // Obtener los jugadores según el ID del partido
            var equipoLocalId = jugadoresArray[claveLocal][valor]
            var equipoVisitanteId = jugadoresArray[claveVisitante][valor];

            // Llenar las opciones con los jugadores
            jugadoresLocal[equipoLocalId].forEach(function(jugador) {
                var option = document.createElement('option');
                option.value = jugador['ID_Jugador'];
                option.textContent = jugador['Nombre'];
                selectorLocal.appendChild(option);
            });

            jugadoresVisitante[equipoVisitanteId].forEach(function(jugador) {
                var option = document.createElement('option');
                option.value = jugador['ID_Jugador'];
                option.textContent = jugador['Nombre'];
                selectorVisitante.appendChild(option);
            });

            // Establecer eventos para los campos de goles para habilitar/deshabilitar jugadores
            document.getElementById('golesLocal').addEventListener('input', function() {
                toggleJugadorSelector();
            });
            document.getElementById('golesVisitante').addEventListener('input', function() {
                toggleJugadorSelector();
            });

            // Mostrar el modal
            document.getElementById('modalAgregarResultado').style.display = 'block';

            // Función para habilitar o deshabilitar el selector de jugadores según los goles
            function toggleJugadorSelector() {
                // Habilitar o deshabilitar el selector de jugadores dependiendo de los goles
                if (document.getElementById('golesLocal').value == 0) {
                    selectorLocal.disabled = true;
                } else {
                    selectorLocal.disabled = false;
                }

                if (document.getElementById('golesVisitante').value == 0) {
                    selectorVisitante.disabled = true;
                } else {
                    selectorVisitante.disabled = false;
                }
            }

            // Llamar a la función al abrir el modal para verificar el estado inicial
            toggleJugadorSelector();
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('modalAgregarResultado').style.display = 'none';
        }
    </script>


    </body>

    </html>