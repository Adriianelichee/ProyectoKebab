// Espera a que el DOM esté completamente cargado antes de ejecutar el código
window.addEventListener('load', () => {

    // Selecciona elementos del DOM
    const table = document.getElementById('tablero');
    const celdas = table.getElementsByTagName('td');
    const jugadores = document.querySelectorAll('.jugador');

    // Variables de control del juego
    let turnox = true; // true para X, false para O
    let juego = ["", "", "", "", "", "", "", "", ""]; // Representa las celdas del tablero

    // Función para iniciar el juego
    function startGame() {
        // Añade un event listener a cada celda del tablero
        Array.from(celdas).forEach((celda, posicionArray) => {
            celda.addEventListener('click', () => makeMove(celda, posicionArray));
        })
    }

    // Función para realizar un movimiento
    function makeMove(celda, posicionArray) {
        // Verifica si la celda está vacía y no hay un ganador aún
        if (juego[posicionArray] === "" && !verifyWinner()) {
            // Marca la celda con X u O según el turno
            juego[posicionArray] = turnox ? 'X' : 'O';
            celda.textContent = juego[posicionArray];

            // Verifica si hay un ganador después del movimiento
            if (verifyWinner()) {
                alert(`El ganador es ${juego[posicionArray]}`);
            } else if (!juego.includes('')) {
                // Si no hay espacios vacíos, es un empate
                alert('El juego ha terminado en empate');
            } else {
                // Cambia el turno y actualiza la interfaz
                turnox = !turnox;
                updateTurn();
            }
        }
    }

    // Función para actualizar la visualización del turno
    function updateTurn() {
        // Remueve la clase 'turno' de todos los jugadores
        jugadores.forEach(jugador => {
            jugador.classList.remove('turno');
        });
        // Añade la clase 'turno' al jugador actual
        jugadores[turnox ? 0 : 1].classList.add('turno');
    }

    // Función para verificar si hay un ganador
    function verifyWinner() {
        // Define todas las combinaciones ganadoras posibles
        const combinacionesGanadoras = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Filas
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columnas
            [0, 4, 8], [2, 4, 6]             // Diagonales
        ];

        // Verifica cada combinación ganadora
        for (let combinacion of combinacionesGanadoras) {
            const a = combinacion[0];
            const b = combinacion[1];
            const c = combinacion[2];
            // Si las tres celdas son iguales y no están vacías, hay un ganador
            if (juego[a] && juego[a] === juego[b] && juego[a] === juego[c]) {
                return true;
            }
        }    
        // Si no se encontró ninguna combinación ganadora
        return false;
    }

    // Inicia el juego
    startGame();
})