<?php
// declare(strict_types=1);
require './conexion.php';
session_start();

// Obtener el índice actual
$currentIndex = isset($_SESSION['current_index']) ? $_SESSION['current_index'] : 0;

// Consulta SQL para obtener la información del registro actual
$sql = "SELECT pe.id AS performance_id, ce.nombre AS concurso, i.nombre AS institucion, i.logo_path AS logo, a.nombre AS alumno, p.nombre AS profesor_nombre, ins.id AS instancia, a.nivel_id AS nivel, pe.tiempo AS tiempo_final, pe.penalizacion AS penalizaciones
        FROM performance pe
        JOIN alumnos a ON pe.alumno_id = a.id
        JOIN instituciones i ON a.institucion_id = i.id
        JOIN profesores p ON a.profesor_id = p.id
        JOIN instancias ins ON pe.instancia_id = ins.id
        JOIN certamenes ce ON ins.certamen_id = ce.id
        ORDER BY ins.id ASC, a.nivel_id ASC
        LIMIT 20 OFFSET $currentIndex";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $performance_id = $row['performance_id']; // Aquí obtenemos el ID de performance
    $concurso = $row['concurso'];
    $institucion = $row['institucion'];
    $logo = $row['logo'];
    $alumno = $row['alumno'];
    // $apellido = $row['apellido'];
    $profesor = $row['profesor_nombre']; // Concatenar nombre y apellido del profesor
    $instance = $row['instancia'];
    $nivel = $row['nivel'];
    $tiempo_final = $row['tiempo_final'];
    $penalizaciones = $row['penalizaciones'];

    // Determinar si el tiempo_final es mayor a 00:00 para deshabilitar los botones
    $deshabilitarBotones = $tiempo_final > '00:00';
} else {
    $concurso = "No data";
    $institucion = "No data";
    $logo = "images/logoinstitucion/default.png"; // Ruta de una imagen genérica por defecto
    $alumno = "No data";
    $profesor = "No data";
    $instance = "N/A";
    $nivel = "N/A";
    $tiempo_final = "00:00";
    $penalizaciones = 0;

    // Si no hay datos, asumimos que los botones deben estar habilitados
    $deshabilitarBotones = false;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./styles/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/index_desktop.css">
    <link rel="stylesheet" href="./styles/index_tablet.css">
    <link rel="stylesheet" href="./styles/index_smartphone.css">
    <title>Panal de Control</title>
</head>
<body>
    <!-- Icono de registro/logueo -->
    <!-- <script src="./js/menuDesplegable.js"></script> -->
    <!-- <section class="lateral_section">
        posible implementacion para el sistema usuarios
        <div id="dropdown" class="dropdown-menu">
            <a href="#login">Iniciar sesión</a>
            <a href="#register">Registrarse</a>
        </div>
    </section> -->
    <!-- Header -->
    <header class="header">
        <div class="header-logo"><img src="./" alt=""></div>
        <div class="header-title">PANAL DE CONTROL</div>
        <div class="header-sign">
            <a href="./registro.php">
                <button class="button_login">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login-2" width="44" height="44" viewBox="0 0 24 24" stroke-width="1" stroke="#fb0" fill="none" stroke-linecap="round" stroke-linejoin="round"> <!--onclick="toggleDropdown()" == menu desplegable -->
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                        <path d="M3 12h13l-3 -3" />
                        <path d="M13 15l3 -3" />
                    </svg>
                </button>
            </a>
        </div>
    </header>
    <!-- Top Section -->
    <section class="index_section" id="top_section">
        <div class="llano_section ">
            <img class="llano-logo" src="./styles/images/logoInstitucion/Llano.png" alt="">
            <h2 id="header_llano">Escuela Tecnica Carmen M. de Llano</h2>
        </div>
        <div class="title_container">
            <h1 id="h1">Instancia Institucional</h1>
        </div>
    </section>
    <!-- Datos de los participantes -->
    <section class="index_section" id="data">
        <section class="sub_section" id="institucion">
            <div class="image">
                <img src="<?php echo $logo; ?>" alt="Logo de la Institución">
            </div>
            <div class="element">
                <div class="etiqueta">Institución: </div>
                <div class="nombre"><?php echo $institucion; ?></div>
            </div>
        </section>
        <section class="sub_section">
            <div class="element" id="participante">
                <div class="etiqueta">Participante:</div>
                <div class="nombre"><?php echo $alumno; ?></div>
            </div>
            <div class="element" id="referente">
                <div class="etiqueta">Referente:</div>
                <div class="nombre"><?php echo $profesor; ?> </div>
            </div>
        </section>
    </section>
    <!-- Cronometro -->
    <section class="index_section" id="timer">
        <div class="main-container">
            <div class="timer_container level-container">
                <div class="timer_element timer_title level-title">Nivel</div>
                <div class="timer_element timer_value level-value"><?php echo $nivel; ?></div>
            </div>

            <div class="timer_container round-container">
                <div class="timer_element timer_title round-title">Round</div>
                <div class="timer_element timer_value round-value"><?php echo $instance; ?></div>
            </div>

            <div id="cronometro"><?php echo $tiempo_final; ?></div>

            <div class="timer_container penalty-container">
                <div class="timer_element timer_title penalty-title">Penalty</div>
                <div class="timer_element timer_value penalty-value"><?php echo $penalizaciones; ?></div>
            </div>

            <div class="timer_container time-container">
                <div class="timer_element timer_title time-title">Time</div>
                <div class="timer_element timer_value time-value">45"</div>
            </div>
        </div>

        <div id="botones">
            <!-- <button id="startStop" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Start</button>
            <button id="reset" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Reset</button>
            <button id="penaltyM" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P -</button>
            <button id="penaltyP" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P +</button>
            <button id="guardar" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Guardar</button> -->
            <button id="startStop" class="boton-estilo">Start</button>
            <button id="reset" class="boton-estilo">Reset</button>
            <button id="penaltyM" class="boton-estilo">P -</button>
            <button id="penaltyP" class="boton-estilo">P +</button>
            <button id="guardar" class="boton-estilo">Guardar</button>
            <button id="prev" class="boton-estilo">Anterior</button>
            <button id="next" class="boton-estilo">Siguiente</button>
            <button id="ranking" class="boton-estilo">Ranking</button>
            <button id="reproducir" class="boton-estilo">Reproducir</button>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Variables globales
            let timer;
            let running = false;
            let startTime;
            let elapsedTime = 0;
            let penaltyValue = 0;

            // Función para habilitar/deshabilitar botones
            function togglePenaltyButton(enable) {
                document.getElementById("penaltyP").disabled = !enable;
                document.getElementById("guardar").disabled = !enable;
            }

            function iniciarCronometro() {
                running = true;
                startTime = Date.now() - elapsedTime;
                timer = setInterval(actualizarCronometro, 10);
                togglePenaltyButton(false);
            }

            function detenerCronometro() {
                running = false;
                clearInterval(timer);
                elapsedTime = Date.now() - startTime;
                togglePenaltyButton(true);
            }

            function reiniciarCronometro() {
                running = false;
                clearInterval(timer);
                elapsedTime = 0;
                penaltyValue = 0;
                document.querySelector(".penalty-value").innerText = penaltyValue;
                document.getElementById("cronometro").innerText = "00.00";
                togglePenaltyButton(false);
            }

            function actualizarCronometro() {
                if (running) {
                    elapsedTime = Date.now() - startTime;
                }
                const totalSeconds = elapsedTime / 1000;
                const displaySegundos = Math.floor(totalSeconds).toString().padStart(2, '0');
                const displayMilisegundos = Math.floor((totalSeconds - Math.floor(totalSeconds)) * 100).toString().padStart(2, '0');
                document.getElementById("cronometro").innerText = `${displaySegundos}.${displayMilisegundos}`;
            }

            function formatTime(totalSeconds) {
                const secs = Math.floor(totalSeconds);
                const ms = Math.round((totalSeconds - secs) * 100);
                const displaySegundos = secs.toString().padStart(2, '0');
                const displayMilisegundos = ms.toString().padStart(2, '0');
                return `${displaySegundos}.${displayMilisegundos}`;
            }

            document.getElementById("startStop").addEventListener("click", function() {
                if (running) {
                    detenerCronometro();
                    this.innerText = "Start";
                } else {
                    iniciarCronometro();
                    this.innerText = "Stop";
                }
            });

            document.getElementById("reset").addEventListener("click", function() {
                reiniciarCronometro();
                document.getElementById("startStop").innerText = "Start";
            });

            document.getElementById("penaltyP").addEventListener("click", function() {
                if (!this.disabled) {
                    penaltyValue += 1;
                    const cronometro = (elapsedTime / 1000) + penaltyValue * 5;
                    document.querySelector(".penalty-value").innerText = penaltyValue;
                    document.getElementById("cronometro").innerText = formatTime(cronometro);
                }
            });

            document.getElementById("penaltyM").addEventListener("click", function() {
                if (penaltyValue > 0) {
                    penaltyValue -= 1;
                    const cronometro = (elapsedTime / 1000) + penaltyValue * 5;
                    document.querySelector(".penalty-value").innerText = penaltyValue;
                    document.getElementById("cronometro").innerText = formatTime(cronometro);
                }
            });

            document.getElementById("guardar").addEventListener("click", function() {
                const finalTime = (elapsedTime / 1000) + penaltyValue * 5;
                const formattedTime = formatTime(finalTime);

                fetch('guardar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            performance_id: <?php echo json_encode($performance_id); ?>,
                            tiempo: formattedTime,
                            penalizaciones: penaltyValue
                        })
                    })
                    .then(response => response.text()) // Cambiar a .text() para verificar el contenido recibido
                    .then(text => {
                        console.log('Respuesta del servidor:', text); // Imprimir el texto de respuesta en la consola
                        return JSON.parse(text); // Intentar convertir el texto a JSON
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Datos guardados exitosamente');
                        } else {
                            alert('Error al guardar los datos: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error al procesar la solicitud:', error);
                        alert('Error al procesar la solicitud');
                    });
            });

            document.addEventListener("keydown", function(event) {
                if ((event.key === " " || event.key === "Spacebar") && event.target.tagName !== "INPUT" && event.target.tagName !== "TEXTAREA") {
                    event.preventDefault();
                    document.getElementById("startStop").click();
                } else if (event.key === "Enter") {
                    reiniciarCronometro();
                    document.getElementById("startStop").innerText = "Start";
                } else if (event.key === "ArrowLeft") {
                    event.preventDefault();
                    document.getElementById("prev").click();
                } else if (event.key === "ArrowRight") {
                    event.preventDefault();
                    document.getElementById("next").click();
                }else if (event.key === "G" || event.key === "g"){
                    event.preventDefault();
                    document.getElementById("siguienteInstancia").click();
                } else if (event.key === "+" || event.key === "-") {
                    document.getElementById(event.key === "+" ? "penaltyP" : "penaltyM").click();
                } else if (event.key === "s" || event.key === "S") {
                    if (!document.getElementById("guardar").hasAttribute("disabled")) {
                        document.getElementById("guardar").click();
                    }
                } else if (event.key === "r" || event.key === "R") {
                    window.location.href = `ranking.php?nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>`;
                }
            });

            document.getElementById("prev").addEventListener("click", function() {
                window.location.href = "navigation.php?action=prev";
            });

            document.getElementById("next").addEventListener("click", function() {
                window.location.href = "navigation.php?action=next";
            });

            document.getElementById("ranking").addEventListener("click", function() {
                window.location.href = `ranking.php?nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>`;
            })

            togglePenaltyButton(false); // Deshabilitar botón P+ y botón de guardar al cargar la página
        });
    </script>
</body>

</html>