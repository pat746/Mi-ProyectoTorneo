<?php 
include '../../includes/nav.php';
require_once '../../models/Conexion.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Equipo</h2>

        <!-- Formulario para editar un equipo -->
        <form id="formActualizarEquipo" action="../../controllers/equipo.controllers.php?action=actualizarEquipo" method="POST">
            <!-- Campo oculto para el ID del equipo -->
            <input type="hidden" name="idEquipo" id="idEquipo">

            <label for="nombreEquipo">Nombre del Equipo:</label>
            <input type="text" id="nombreEquipo" name="nombreEquipo" required>

            <label for="ciudad">Ciudad</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <label for="anioFundacion">Año de Fundación:</label>
            <input type="text" id="anioFundacion" name="anioFundacion" required>

            <label for="estadioId">Estadio:</label>
            <select id="estadioId" name="Estadio_ID" required>
                <option value="">Seleccionar Estadio</option>
                <!-- Los estadios disponibles se llenarán mediante JavaScript -->
            </select>

            <button type="submit">Actualizar Equipo</button>
            <!-- Botón Cancelar que redirige a la lista de equipos -->
            <a href="ListarEquipo.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener los datos del equipo por su ID
function obtenerEquipo(idEquipo) {
    console.log(`Obteniendo datos para el equipo con ID: ${idEquipo}`);
    fetch(`../../controllers/equipo.controllers.php?action=obtenerEquipo&ID_Equipo=${idEquipo}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Aquí aseguramos que se llenen los campos con los datos del equipo
            document.getElementById('idEquipo').value = data.ID_Equipo;  // Establecer el ID del equipo en el campo oculto
            document.getElementById('nombreEquipo').value = data.Nombre_Equipo;  // Nombre del equipo
            document.getElementById('ciudad').value = data.Ciudad; 
            document.getElementById('anioFundacion').value = data.Año_Fundación;  // Año de fundación
            document.getElementById('estadioId').value = data.Estadio_ID;  // ID del estadio
        }
    })
    .catch(error => {
        console.error('Error al obtener el equipo:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}

// Obtener el ID del equipo desde la URL
const idEquipo = obtenerParametroURL('id');
if (idEquipo) {
    obtenerEquipo(idEquipo);
} else {
    alert('ID del equipo no especificado en la URL.');
}

function obtenerEstadiosDisponibles() {
    fetch('../../controllers/equipo.controllers.php?action=obtenerEstadiosDisponibles')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Llenar el select con los estadios disponibles
            const selectEstadio = document.getElementById('estadioId');
            data.forEach(estadio => {
                const option = document.createElement('option');
                option.value = estadio.ID_Estadio;
                option.textContent = estadio.Nombre_Estadio;  // Nombre del estadio
                selectEstadio.appendChild(option);
            });
        }
    })
    .catch(error => {
        console.error('Error al obtener los estadios disponibles:', error);
        alert('Hubo un problema al cargar los estadios disponibles.');
    });
}

// Llamar a la función para cargar los estadios disponibles
obtenerEstadiosDisponibles();


// Evento de envío del formulario para actualizar el equipo
document.getElementById('formActualizarEquipo').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idEquipo = document.getElementById('idEquipo').value;
    const nombreEquipo = document.getElementById('nombreEquipo').value;
    const ciudad = document.getElementById('ciudad').value;
    const anioFundacion = document.getElementById('anioFundacion').value;
    const estadioId = document.getElementById('estadioId').value;

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/equipo.controllers.php?action=actualizarEquipo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            ID_Equipo: idEquipo,
            Nombre_Equipo: nombreEquipo,
            Ciudad: ciudad,
            Año_Fundación: anioFundacion,
            Estadio_ID: estadioId  // Asegúrate de que el nombre del campo coincida
        })
    })
    .then(response => response.json())  // Convertir la respuesta a JSON
    .then(data => {
        console.log(data); // Mostrar la respuesta de la actualización
        if (data.success) {
            alert('Equipo actualizado correctamente');
            window.location.href = 'ListarEquipo.php'; // Redirigir a la lista de equipos
        } else {
            alert('Hubo un problema al actualizar el equipo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el Equipo:', error);
        alert('Error al actualizar el Equipo.');
    });
});
</script>
