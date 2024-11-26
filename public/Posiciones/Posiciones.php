<?php include '../../includes/nav.php'; ?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">

<?php
// URL para obtener las posiciones desde el controlador
// $url = 'http://localhost/campeonato/controllers/posiciones.controllers.php?action=obtenerPosiciones';

$url = 'http://localhost/campeonato/controllers/torneo.controllers.php?action=obtenerTorneos';
// Realizar la llamada al controlador y obtener los datos en formato JSON
$response = file_get_contents($url);

// Decodificar el JSON en un array asociativo
$torneos = json_decode($response, true);

// Verifica si la decodificación fue exitosa
if ($torneos === null) {
    echo '<p>Error al decodificar el JSON: ' . json_last_error_msg() . '</p>';
    $torneos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Posiciones</title>
    <link rel="stylesheet" href="../../css/estiloGlobal.css"> 
</head>
<body>

    <h1>Tabla de Posiciones</h1>

    <div>
        <!-- Selecion de torneos -->
        <label for="torneo">Torneo:</label>
        <select id="torneo" name="torneo" onchange="filtrarPosiciones()">
            <option value="">Seleccione un torneo</option>
            <?php foreach ($torneos as $torneo): ?>
                <option value="<?php echo htmlspecialchars($torneo['ID_Torneo']); ?>">
                    <?php echo htmlspecialchars($torneo['Nombre_Torneo']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button onclick="filtrarPosiciones()">Filtrar</button>

    </div>

    <!-- Tabla para mostrar las posiciones -->
    <table>
    <thead>
        <tr>
            <th>Posición</th>
            <th>Equipo</th>
            <th>Partidos Jugados (PJ)</th>
            <th>Ganados</th>
            <th>Empates (E)</th>
            <th>Perdidos (P)</th>
            <th>GF</th>
            <th>GC</th>
            <th>DG</th>
            <th>Puntos (PTS)</th>
        </tr>
    </thead>
    <tbody id="cuerpoTorneo">
        <tr>
            <td colspan="10" style="text-align: center;">No hay datos para mostrar</td>
        </tr>
    </tbody>
</table>
    <!-- Botón para agregar una nueva posición si lo deseas -->
    <!-- Si necesitas agregar posiciones, descomenta y ajusta este enlace -->
    <!-- <a href="http://localhost/campeonato/public/posiciones/RegistrarPosicion.php" class="btn-add">Agregar Posición</a> -->


<script>
    function filtrarPosiciones() {
        // Obtener el ID del torneo seleccionado
        const torneoSelect = document.getElementById("torneo");
        const idTorneo = torneoSelect.value;

        // Verificar que se haya seleccionado un torneo
        if (!idTorneo) {
            alert("Por favor, seleccione un torneo.");
            return;
        }
        
        // Realizar la solicitud fetch con el id_torneo
        fetch(`http://localhost/campeonato/controllers/posiciones.controllers.php?action=obtenerPosiciones&idTorneo=${idTorneo}`, {
            method: "GET", // Cambia a POST si es necesario
            headers: {
                "Content-Type": "application/json",
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener las posiciones");
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                // Actualizar la tabla con las posiciones
                const cuerpoTorneo = document.getElementById("cuerpoTorneo");

                // Limpiar el contenido previo
                cuerpoTorneo.innerHTML = "";

                // Verificar si hay datos
                if (data.length === 0) {
                    cuerpoTorneo.innerHTML = `
                        <tr>
                            <td colspan="10" style="text-align: center;">No hay datos para mostrar</td>
                        </tr>`;
                    return;
                }

                // Generar filas con los datos obtenidos
                data.forEach((posicion, index) => {
                    const fila = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${posicion.Equipo}</td>
                            <td>${posicion.PJ !== null ? posicion.PJ : 0}</td>
                            <td>${posicion.G !== null ? posicion.G : 0}</td>
                            <td>${posicion.E !== null ? posicion.E : 0}</td>
                            <td>${posicion.P !== null ? posicion.P : 0}</td>
                            <td>${posicion.GF !== null ? posicion.GF : 0}</td>
                            <td>${posicion.GC !== null ? posicion.GC : 0}</td>
                            <td>${posicion.DG !== null ? posicion.DG : 0}</td>
                            <td>${posicion.PTS !== null ? posicion.PTS : 0}</td>
                        </tr>`;
                    cuerpoTorneo.innerHTML += fila;
                });
            })
            .catch(error => {
                console.error("Error al cargar posiciones:", error);
                alert("Hubo un problema al cargar las posiciones.");
            });
    }
</script>
<head>
    <link rel="stylesheet" href="./stalys.css">
</head>
</body>
</html>


