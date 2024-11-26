<?php 
include '../../includes/nav.php'; 
require_once '../../models/Conexion.php'; 
ini_set('display_errors', 0);  // Desactiva la visualización de errores
ini_set('log_errors', 1);      // Habilita el registro de errores
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Estadio</h2>

        <!-- Formulario para editar un estadio -->
        <form id="formActualizarEstadio" action="../../controllers/estadio.controllers.php?action=actualizarEstadio" method="POST">
            <!-- Campo oculto para el ID del estadio -->
            <input type="hidden" name="ID_Estadio" id="idEstadio">

            <label for="Nombre_Estadio">Nombre del Estadio:</label>
            <input type="text" id="nombreEstadio" name="Nombre_Estadio" required>

            <label for="Capacidad">Capacidad:</label>
            <input type="number" id="capacidad" name="Capacidad" required>

            <label for="Ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="Ciudad" required>

            <label for="Año_Inauguración">Año de Inauguración:</label>
            <input type="text" id="anoInauguracion" name="Año_Inauguración" required>

            <button type="submit">Actualizar Estadio</button>
            <!-- Botón Cancelar que redirige a la lista de estadios -->
            <a href="ListarEstadio.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener el estadio por ID y llenar el formulario
function obtenerEstadio(idEstadio) {
    fetch(`../../controllers/estadio.controllers.php?action=obtenerEstadio&ID_Estadio=${idEstadio}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Aquí aseguramos que se llenen los campos con los datos del estadio
            document.getElementById('idEstadio').value = data.ID_Estadio;  // Establecer el ID_Estadio en el campo oculto
            document.getElementById('nombreEstadio').value = data.Nombre_Estadio;
            document.getElementById('capacidad').value = data.Capacidad;
            document.getElementById('ciudad').value = data.Ciudad;
            document.getElementById('anoInauguracion').value = data.Año_Inauguración;
        }
    })
    .catch(error => {
        console.error('Error al obtener el estadio:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}

// Obtener el ID del estadio desde la URL
const idEstadio = obtenerParametroURL('id');
if (idEstadio) {
    obtenerEstadio(idEstadio);
} else {
    alert('ID del estadio no especificado en la URL.');
}

// Manejo del envío del formulario
document.getElementById('formActualizarEstadio').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idEstadio = document.getElementById('idEstadio').value;
    const nombreEstadio = document.getElementById('nombreEstadio').value;
    const capacidad = document.getElementById('capacidad').value;
    const ciudad = document.getElementById('ciudad').value;
    const anoInauguracion = document.getElementById('anoInauguracion').value;

    // Imprimir los valores en la consola para verificar
    console.log({
        ID_Estadio: idEstadio,
        Nombre_Estadio: nombreEstadio,
        Capacidad: capacidad,
        Ciudad: ciudad,
        Año_Inauguración: anoInauguracion
    });

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/estadio.controllers.php?action=actualizarEstadio', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Aseguramos que el tipo de contenido sea correcto
        },
        body: new URLSearchParams({
            ID_Estadio: idEstadio,
            Nombre_Estadio: nombreEstadio,
            Capacidad: capacidad,
            Ciudad: ciudad,
            Año_Inauguración: anoInauguracion
        })
    })
    .then(response => response.json())  // Esperar la respuesta en JSON
    .then(data => {
        if (data.success) {
            alert('Estadio actualizado correctamente');
            window.location.href = 'ListarEstadio.php'; // Redirigir a la página de estadios o lo que desees
        } else {
            alert('Hubo un problema al actualizar el estadio: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el estadio:', error);
        alert('Error al actualizar el estadio.');
    });
});

</script>
