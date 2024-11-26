const ball = document.getElementById("ball");
const ballContainer = document.getElementById("ball-container");

// Variables para la rotación total y la velocidad de rotación
let totalRotation = 0;
let rotationSpeed = 0.5; // Velocidad inicial de rotación

// Función para manejar el movimiento del balón
function handleBallMovement() {
    const windowHeight = window.innerHeight; // Altura de la ventana
    const scrollY = window.scrollY; // Posición de desplazamiento
    const documentHeight = document.body.scrollHeight; // Altura total del documento
    const maxScroll = documentHeight - windowHeight; // Altura máxima de desplazamiento

    // Control de visibilidad del balón
    if (scrollY > 0 && scrollY < maxScroll) {
        ballContainer.style.opacity = 1; // Muestra el balón solo mientras hay scroll
    } else {
        ballContainer.style.opacity = 0; // Oculta el balón al final de la página
    }

    // Calcular el tamaño del balón basado en el desplazamiento
    const midPoint = windowHeight / 2; // Punto medio de la ventana
    const scaleUp = Math.max(1, Math.min(15, (scrollY / midPoint) * 15)); // Aumentar el tamaño hasta 15x
    const scaleDownStart = midPoint; // Punto donde comienza a encogerse
    const scaleDown = Math.max(1, 15 - (scrollY - scaleDownStart) / (maxScroll - scaleDownStart) * 14); // Reducir tamaño después de la mitad
    const scale = scrollY <= scaleDownStart ? scaleUp : scaleDown; // Escalar dependiendo de la posición

    // Ajustar la velocidad de rotación en función del desplazamiento
    if (scale >= 15) {
        rotationSpeed = 10; // Velocidad rápida al máximo tamaño
    } else {
        // Aumentar la velocidad al acercarse al tamaño máximo
        rotationSpeed = Math.min(10, (scale / 15) * 10);
    }

    // Aumentar la rotación total en función de la velocidad
    totalRotation += rotationSpeed; // Aumentar rotación por velocidad

    // Aplica el zoom y la rotación
    ball.style.transform = `translate(-50%, -50%) scale(${scale}) rotate(${totalRotation}deg)`; // Aplica el zoom y la rotación

    // Ajustar posición del balón para movimiento curvo
    const ballPositionY = (scrollY / maxScroll) * (documentHeight - windowHeight); // Controlar la posición Y del balón
    const ballPositionX = (scrollY / maxScroll) * (window.innerWidth - ball.clientWidth); // Movimiento a la derecha

    // Para simular un movimiento curvo
    const curveFactor = Math.sin((scrollY / maxScroll) * Math.PI) * 100; // Factor de curva
    ballContainer.style.top = `${ballPositionY + curveFactor}px`; // Ajusta la posición Y
    ballContainer.style.left = `${ballPositionX}px`; // Ajusta la posición X

    // Asegúrate de que el balón no se mantenga visible al final de la página
    if (scrollY >= maxScroll) {
        ballContainer.style.opacity = 0; // Asegura que el balón se oculte al final
    }
}

// Evento para detectar el scroll
window.addEventListener("scroll", handleBallMovement);
