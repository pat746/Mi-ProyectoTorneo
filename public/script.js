// Muestra u oculta los formularios
function toggleFormularios() {
    const formDiv = document.getElementById("formularioContainer");
    
    // Alternar la visibilidad del contenedor de formularios
    if (formDiv.style.display === "block") {
        formDiv.style.display = "none";  // Ocultar formularios
    } else {
        formDiv.style.display = "block";  // Mostrar formularios
    }

    // Cambia el texto del botón si es necesario
    const formButton = document.querySelector(".toggle-form-button");
    if (formButton) {
        formButton.innerText = formDiv.style.display === "block" ? "Ocultar Formularios" : "Mostrar Formularios";
    }
}

// Función para mostrar y ocultar la barra lateral
function toggleNav() {
    var sidebar = document.getElementById("sidebar");
    var main = document.getElementById("main");
    var closeBtn = document.querySelector(".closebtn");

    if (sidebar.classList.contains('closed')) {
        sidebar.classList.remove('closed');
        sidebar.classList.add('open');
        main.classList.add('shifted');
        closeBtn.style.left = "150px"; // Mueve el botón hacia el borde del sidebar abierto
    } else {
        sidebar.classList.add('closed');
        sidebar.classList.remove('open');
        main.classList.remove('shifted');
        closeBtn.style.left = "0"; // Coloca el botón en el borde izquierdo cuando está cerrado
    }
}



// Mover el botón según el scroll
window.onscroll = function() {
    var toggleBtn = document.querySelector(".closebtn");
    var scrollTop = window.scrollY || document.documentElement.scrollTop;

    // Ajusta la posición vertical del botón con el desplazamiento
    toggleBtn.style.top = (10 + scrollTop) + 'px'; // Ajusta el valor según sea necesario
};





// Cargar gráficos y datos de la tabla
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('myChart').getContext('2d');
    var selectTorneo = document.getElementById('selectTorneo');
    var statsTableBody = document.getElementById('statsTable').querySelector('tbody');

    var chartData = {
        labels: [],
        datasets: [{
            label: 'Puntos por Equipo',
            data: [],
            borderColor: colorBoder,
            backgroundColor: colorsBg,
            borderWidth: 1
        }]
    };

    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: chartOptions
    });

    function actualizarGrafico(torneoId) {
        fetch(`http://localhost/campeonato/controllers/torneo.controllers.php?obtenerEstadisticas=true&torneoId=${torneoId}`)
            .then(response => response.json())
            .then(data => {
                // Limpiar datos anteriores
                myChart.data.labels = [];
                myChart.data.datasets[0].data = [];
                statsTableBody.innerHTML = '';

                // Llenar con nuevos datos
                data.forEach((row) => {
                    myChart.data.labels.push(row.nombreEquipo);
                    myChart.data.datasets[0].data.push(row.puntos);

                    var rowElement = document.createElement('tr');
                    rowElement.innerHTML = `
                        <td>${row.nombreEquipo}</td>
                        <td>${row.partidos_jugados}</td>
                        <td>${row.partidos_ganados}</td>
                        <td>${row.partidos_perdidos}</td>
                        <td>${row.partidos_empatados}</td>
                        <td>${row.puntos}</td>
                    `;
                    statsTableBody.appendChild(rowElement);
                });

                myChart.update();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Error al obtener los datos. Por favor, intenta de nuevo.');
            });
    }

    function llenarSelectTorneos(torneos) {
        torneos.forEach(torneo => {
            var option = document.createElement('option');
            option.value = torneo.idTorneo;
            option.textContent = torneo.nombreTorneo;
            selectTorneo.appendChild(option);
        });

        if (torneos.length > 0) {
            actualizarGrafico(torneos[0].idTorneo);
        }
    }

    fetch(`http://localhost/campeonato/controllers/torneo.controllers.php?obtenerTorneos=true`)
        .then(response => response.json())
        .then(torneos => {
            llenarSelectTorneos(torneos);
        })
        .catch(error => {
            console.error('Error fetching tournaments:', error);
            alert('Error al obtener los torneos disponibles. Por favor, intenta de nuevo.');
        });

    selectTorneo.addEventListener('change', function () {
        var selectedTorneoId = selectTorneo.value;
        actualizarGrafico(selectedTorneoId);
    });
});
