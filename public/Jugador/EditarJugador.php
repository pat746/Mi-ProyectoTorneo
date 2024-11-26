<?php 
include '../../includes/nav.php';
require_once '../../models/Conexion.php';
ini_set('display_errors', 0);  // Desactiva la visualización de errores
ini_set('log_errors', 1);      // Habilita el registro de errores
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Jugador</h2>

        <!-- Formulario para editar un jugador -->
        <form id="formActualizarJugador" action="../../controllers/jugador.controllers.php?action=actualizarJugador" method="POST">
            <!-- Campo oculto para el ID del jugador -->
            <input type="hidden" name="ID_Jugador" id="idJugador">

            <!-- Nombre -->
            <label for="Nombre">Nombre:</label>
            <input type="text" id="nombre" name="Nombre" required>

            <!-- Apellido -->
            <label for="Apellido">Apellido:</label>
            <input type="text" id="apellido" name="Apellido" required>

            <!-- Fecha de Nacimiento -->
            <label for="Fecha_Nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fechaNacimiento" name="Fecha_Nacimiento" required>

            <!-- Posición -->
            <label for="Posicion">Posición:</label>
            <input type="text" id="posicion" name="Posicion" required>

            <!-- Nacionalidad -->
            <label for="Nacionalidad">Nacionalidad:</label>
            <input type="text" id="nacionalidad" name="Nacionalidad" required>

            <button type="submit">Actualizar Jugador</button>
            <!-- Botón Cancelar que redirige a la lista de jugadores -->
            <a href="ListarJugador.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener el jugador por ID y llenar el formulario
function obtenerJugador(idJugador) {
    fetch(`../../controllers/jugador.controllers.php?action=obtenerJugador&ID_Jugador=${idJugador}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Aquí aseguramos que se llenen los campos con los datos del jugador
            document.getElementById('idJugador').value = data.ID_Jugador;  // Establecer el ID_Jugador en el campo oculto
            document.getElementById('nombre').value = data.Nombre;
            document.getElementById('apellido').value = data.Apellido;
            document.getElementById('fechaNacimiento').value = data.Fecha_Nacimiento;
            document.getElementById('posicion').value = data.Posición;
            document.getElementById('nacionalidad').value = data.Nacionalidad;
        }
    })
    .catch(error => {
        console.error('Error al obtener el jugador:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}

// Obtener el ID del jugador desde la URL
const idJugador = obtenerParametroURL('id');
if (idJugador) {
    obtenerJugador(idJugador);
} else {
    alert('ID del jugador no especificado en la URL.');
}

// Enviar el formulario de actualización
document.getElementById('formActualizarJugador').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idJugador = document.getElementById('idJugador').value;
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const posicion = document.getElementById('posicion').value;
    const nacionalidad = document.getElementById('nacionalidad').value;

    // Imprimir los valores en la consola para verificar
    console.log({
        ID_Jugador: idJugador,
        Nombre: nombre,
        Apellido: apellido,
        Fecha_Nacimiento: fechaNacimiento,
        Posición: posicion,
        Nacionalidad: nacionalidad
    });

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/jugador.controllers.php?action=actualizarJugador', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Aseguramos que el tipo de contenido sea correcto
        },
        body: new URLSearchParams({
            ID_Jugador: idJugador,
            Nombre: nombre,
            Apellido: apellido,
            Fecha_Nacimiento: fechaNacimiento,
            Posición: posicion,
            Nacionalidad: nacionalidad
        })
    })
    .then(response => response.json())  // Esperar la respuesta en JSON
    .then(data => {
        if (data.success) {
            alert('Jugador actualizado correctamente');
            window.location.href = 'ListarJugador.php'; // Redirigir a la página de jugadores o lo que desees
        } else {
            alert('Hubo un problema al actualizar el jugador: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el jugador:', error);
        alert('Error al actualizar el jugador.');
    });
});
</script>
