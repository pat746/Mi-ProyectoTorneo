<?php 
include '../../includes/nav.php';
require_once '../../models/Conexion.php';
ini_set('display_errors', 0);  // Desactiva la visualización de errores
ini_set('log_errors',  1);      // Habilita el registro de errores 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Torneo</title>
    <!-- Vincula el archivo CSS externo -->
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Torneo</h2>

        <!-- Formulario para editar un torneo -->
        <form id="formActualizarTorneo" action="../../controllers/torneo.controllers.php?action=actualizarTorneo" method="POST">
            <!-- Campo oculto para el ID del torneo -->
            <input type="hidden" name="ID_Torneo" id="idTorneo">

            <label for="Nombre_Torneo">Nombre del Torneo:</label>
            <input type="text" id="nombreTorneo" name="Nombre_Torneo" required>

            <label for="Temporada">Temporada:</label>
            <input type="text" id="temporada" name="Temporada" required>

            <label for="Tipo_Torneo">Tipo de Torneo:</label>
            <input type="text" id="tipoTorneo" name="Tipo_Torneo" required>

            <label for="Pais">País:</label>
            <input type="text" id="pais" name="Pais" required>

            <button type="submit">Actualizar Torneo</button>
            <!-- Botón Cancelar que redirige a la lista de torneos -->
            <a href="ListarTorneo.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener el torneo por ID y llenar el formulario
function obtenerTorneo(idTorneo) {
    fetch(`../../controllers/torneo.controllers.php?action=obtenerTorneo&ID_Torneo=${idTorneo}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Aquí aseguramos que se llenen los campos con los datos del torneo
            document.getElementById('idTorneo').value = data.ID_Torneo;  // Establecer el ID_Torneo en el campo oculto
            document.getElementById('nombreTorneo').value = data.Nombre_Torneo;
            document.getElementById('temporada').value = data.Temporada;
            document.getElementById('tipoTorneo').value = data.Tipo_Torneo;
            document.getElementById('pais').value = data.Pais;
        }
    })
    .catch(error => {
        console.error('Error al obtener el torneo:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}

// Obtener el ID del torneo desde la URL
const idTorneo = obtenerParametroURL('id');
if (idTorneo) {
    obtenerTorneo(idTorneo);
} else {
    alert('ID del torneo no especificado en la URL.');
}

document.getElementById('formActualizarTorneo').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idTorneo = document.getElementById('idTorneo').value;
    const nombreTorneo = document.getElementById('nombreTorneo').value;
    const temporada = document.getElementById('temporada').value;
    const tipoTorneo = document.getElementById('tipoTorneo').value;
    const pais = document.getElementById('pais').value;

    // Imprimir los valores en la consola para verificar
    console.log({
        ID_Torneo: idTorneo,
        Nombre_Torneo: nombreTorneo,
        Temporada: temporada,
        Tipo_Torneo: tipoTorneo,
        Pais: pais
    });

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/torneo.controllers.php?action=actualizarTorneo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded', // Aseguramos que el tipo de contenido sea correcto
        },
        body: new URLSearchParams({
            ID_Torneo: idTorneo,
            Nombre_Torneo: nombreTorneo,
            Temporada: temporada,
            Tipo_Torneo: tipoTorneo,
            Pais: pais
        })
    })
    .then(response => response.json())  // Esperar la respuesta en JSON
    .then(data => {
        if (data.success) {
            alert('Torneo actualizado correctamente');
            window.location.href = 'ListarTorneo.php'; // Redirigir a la página de torneos o lo que desees
        } else {
            alert('Hubo un problema al actualizar el torneo: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el torneo:', error);
        alert('Error al actualizar el torneo.');
    });
});
</script>

</body>
</html>
