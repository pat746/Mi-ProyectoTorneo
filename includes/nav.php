<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación</title>
    <style>
        body {
            font-family: "Lato", sans-serif;
            margin: 0;
            padding: 0;
            transition: margin-left 0.5s;
        }

        /* Estilos del sidebar */
        .sidebar {
            height: 100%;
            width: 200px; /* Ancho del sidebar */
            position: fixed;
            top: 0;
            left: -200px; /* Empieza oculto */
            background-color: #111;
            overflow-x: hidden;
            transition: left 0.5s;
            padding-top: 10px;
            z-index: 1000;
        }

        .sidebar.open {
            left: 0; /* Muestra el sidebar */
        }

        /* Estilo de los enlaces del sidebar */
        .sidebar a {
            padding: 8px 15px;
            text-decoration: none;
            font-size: 15px;
            color: #818181;
            display: block;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        /* Estilo para el botón de menú */
        .toggle-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            transition: background-color 0.3s;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .toggle-btn:hover {
            background-color: #444;
        }

        /* Estilo del contenido principal que se empuja */
        .main-content {
            transition: margin-left 0.5s;
            padding: 16px;
        }

        .main-content.push {
            margin-left: 200px; /* Empuja el contenido hacia la derecha */
        }

    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="mySidebar">
    <a href="http://localhost/campeonato/">Inicio</a>
    <a href="http://localhost/campeonato/public/Jugador/ListarJugador.php">Jugador</a>
    <a href="http://localhost/campeonato/public/Contrato/ListarContrato.php">Contrato</a>
    <a href="http://localhost/campeonato/public/Estadio/ListarEstadio.php">Estadio</a>
    <a href="http://localhost/campeonato/public/Equipo/ListarEquipo.php">Equipo</a>
    <a href="http://localhost/campeonato/public/Arbitro/ListarArbitro.php">Arbitro</a>
    <a href="http://localhost/campeonato/public/EquipoTorneo/ListarEquipoTorneo.php?ID_Torneo=">TorneoEquipo</a>
    <a href="http://localhost/campeonato/public/Partido/ListarPartido.php">Partido</a>
    <a href="http://localhost/campeonato/public/Resultado/ListarResultado.php">Resultado</a>
    <a href="http://localhost/campeonato/public/Goles/ListarGoles.php">Goles</a>
    <a href="http://localhost/campeonato/public/torneo/ListarTorneo.php">Torneo</a>
    <a href="http://localhost/campeonato/public/posiciones/Posiciones.php">Estadísticas</a>
</div>

<!-- El contenido se insertará en el archivo que lo llame -->
<script>
    function toggleNav() {
        var sidebar = document.getElementById("mySidebar");
        var mainContent = document.querySelector(".main-content");

        // Si el sidebar tiene la clase 'open', se la quita; si no la tiene, se la agrega.
        sidebar.classList.toggle("open");
        mainContent.classList.toggle("push");
    }
</script>

</body>
</html>
