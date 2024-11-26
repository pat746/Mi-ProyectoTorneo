<?php 
include '../../includes/nav.php';
require_once '../../models/Conexion.php';
ini_set('display_errors', 0);  // Desactiva la visualización de errores
ini_set('log_errors', 1);      // Habilita el registro de errores
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Árbitro</h2>

        <!-- Formulario para editar un árbitro -->
        <form id="formActualizarArbitro" action="../../controllers/arbitro.controllers.php?action=actualizarArbitro" method="POST">
            <!-- Campo oculto para el ID del árbitro -->
            <input type="hidden" name="ID_Árbitro" id="idArbitro">

            <label for="Nombre">Nombre:</label>
            <input type="text" id="nombre" name="Nombre" required>

            <label for="Apellido">Apellido:</label>
            <input type="text" id="apellido" name="Apellido" required>

            <label for="Nacionalidad">Nacionalidad:</label>
            <input type="text" id="nacionalidad" name="Nacionalidad" required>

            <label for="Experiencia">Experiencia:</label>
            <input type="text" id="experiencia" name="Experiencia" required>

            <button type="submit">Actualizar Árbitro</button>
            <!-- Botón Cancelar que redirige a la lista de árbitros -->
            <a href="ListarArbitros.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener el árbitro por ID y llenar el formulario
function obtenerArbitro(idArbitro) {
    fetch(`../../controllers/arbitro.controllers.php?action=obtenerArbitro&ID_Árbitro=${idArbitro}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Aquí aseguramos que se llenen los campos con los datos del árbitro
            document.getElementById('idArbitro').value = data.ID_Árbitro;  // Establecer el ID_Arbitro en el campo oculto
            document.getElementById('nombre').value = data.Nombre;
            document.getElementById('apellido').value = data.Apellido;
            document.getElementById('nacionalidad').value = data.Nacionalidad;
            document.getElementById('experiencia').value = data.Experiencia;
        }
    })
    .catch(error => {
        console.error('Error al obtener el árbitro:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}

// Obtener el ID del árbitro desde la URL
const idArbitro = obtenerParametroURL('id');
if (idArbitro) {
    obtenerArbitro(idArbitro);
} else {
    alert('ID del árbitro no especificado en la URL.');
}

document.getElementById('formActualizarArbitro').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idArbitro = document.getElementById('idArbitro').value;
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const nacionalidad = document.getElementById('nacionalidad').value;
    const experiencia = document.getElementById('experiencia').value;

    // Imprimir los valores en la consola para verificar
    console.log({
        ID_Árbitro: idArbitro,
        Nombre: nombre,
        Apellido: apellido,
        Nacionalidad: nacionalidad,
        Experiencia: experiencia
    });

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/arbitro.controllers.php?action=actualizarArbitro', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Aseguramos que el tipo de contenido sea correcto
        },
        body: new URLSearchParams({
            ID_Árbitro: idArbitro,
            Nombre: nombre,
            Apellido: apellido,
            Nacionalidad: nacionalidad,
            Experiencia: experiencia
        })
    })
    .then(response => response.json())  // Esperar la respuesta en JSON
    .then(data => {
        if (data.success) {
            alert('Árbitro actualizado correctamente');
            window.location.href = 'ListarArbitro.php'; // Redirigir a la página de árbitros o lo que desees
        } else {
            alert('Hubo un problema al actualizar el árbitro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el árbitro:', error);
        alert('Error al actualizar el árbitro.');
    });
});
</script>
