<?php 
include '../../includes/nav.php'; 
require_once '../../models/Conexion.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<div class="main-content">
    <button class="toggle-btn" onclick="toggleNav()">&#9776;</button>
    <div class="content">
        <h2>Editar Contrato</h2>

        <!-- Formulario para editar un contrato -->
        <form id="formActualizarContrato" action="../../controllers/contrato.controllers.php?action=actualizarContrato" method="POST">
            <!-- Campo oculto para el ID del contrato -->
            <input type="hidden" name="idContrato" id="idContrato" >

           <!-- Mostrar el nombre del jugador -->
           <label for="idJugador">Jugador:</label>
            <input type="text" id="idJugador" name="idJugador" required >

            <label for="idEquipo">Equipo</label>
            <select id="idEquipo" name="idEquipo" required>
                <option value="">Seleccione un equipo</option>
                <?php 
                    // Cargar los equipos desde la base de datos
                    include_once '../../models/Equipo.php';
                    $equipo = new Equipo();
                    $equipos = $equipo->getAll(); // Método que devuelve los equipos disponibles
                    foreach ($equipos as $equipo) {
                        echo "<option value='" . $equipo['ID_Equipo'] . "'>" . $equipo['Nombre_Equipo'] . "</option>";
                    }
                ?>
            </select>

            <label for="fechaInicio">Fecha de Inicio</label>
            <input type="date" id="fechaInicio" name="fechaInicio" required>

            <label for="fechaFin">Fecha de Fin</label>
            <input type="date" id="fechaFin" name="fechaFin" required>

            <label for="salario">Salario</label>
            <input type="number" id="salario" name="salario" required>

            <label for="tipoContrato">Tipo de Contrato</label>
            <select id="tipoContrato" name="tipoContrato" >
                <option value="">Seleccione el tipo de contrato</option>
                <option value="Fijo">Fijo</option>
                <option value="Temporal">Temporal</option>
                <option value="Part-time">Part-time</option>
            </select>

            <button type="submit">Actualizar Contrato</button>
            <!-- Botón Cancelar que redirige a la lista de contratos -->
            <a href="ListarContratos.php" class="cancel-btn"><button type="button">Cancelar</button></a>
        </form>
    </div>
</div>

<script>
// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para obtener los datos del contrato por su ID
function obtenerContrato(idContrato) {
    console.log(`Obteniendo datos para el contrato con ID: ${idContrato}`);
    fetch(`../../controllers/contrato.controllers.php?action=obtenerContrato&ID_Contrato=${idContrato}`)
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.error) {
            console.error(data.error);
            alert(data.error);
        } else {
            // Mostrar datos recibidos
            document.getElementById('idContrato').value = data.ID_Contrato;
            document.getElementById('idJugador').value = data.ID_Jugador;
            document.getElementById('idEquipo').value = data.ID_Equipo;
            document.getElementById('fechaInicio').value = data.Fecha_Inicio;
            document.getElementById('fechaFin').value = data.Fecha_Fin;
            document.getElementById('salario').value = data.Salario;
            document.getElementById('tipoContrato').value = data.Tipo_Contrato;
        }
    })
    .catch(error => {
        console.error('Error al obtener el contrato:', error);
        alert('Hubo un problema al cargar los datos.');
    });
}



// Asegúrate de que 'id' es el parámetro correcto en la URL
const idContrato = obtenerParametroURL('id');
console.log('ID del contrato:', idContrato); 

// Evento de envío del formulario para actualizar el contrato
document.getElementById('formActualizarContrato').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevenir el envío normal del formulario

    const idContrato = document.getElementById('idContrato').value;
    const idJugador = document.getElementById('idJugador').value;
    const idEquipo = document.getElementById('idEquipo').value;
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    const salario = document.getElementById('salario').value;
    const tipoContrato = document.getElementById('tipoContrato').value;

    // Enviar los datos con fetch para actualizar
    fetch('../../controllers/contrato.controllers.php?action=actualizarContrato', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            ID_Contrato: idContrato,
            ID_Jugador: idJugador,
            ID_Equipo: idEquipo,
            Fecha_Inicio: fechaInicio,
            Fecha_Fin: fechaFin,
            Salario: salario,
            Tipo_Contrato: tipoContrato
        })
    })
    .then(response => response.json())  // Convertir la respuesta a JSON
    .then(data => {
        console.log(data); // Mostrar la respuesta de la actualización
        if (data.success) {
            alert('Contrato actualizado correctamente');
            window.location.href = 'ListarContratos.php'; // Redirigir a la lista de contratos
        } else {
            alert('Hubo un problema al actualizar el contrato: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error al actualizar el contrato:', error);
        alert('Error al actualizar el contrato.');
    });
});
</script>
