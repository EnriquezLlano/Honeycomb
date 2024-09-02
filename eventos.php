<?php
require 'conexion.php';
session_start();

// Obtener el índice actual
if (!isset($_SESSION['current_index'])) {
    $_SESSION['current_index'] = 0;
}
$currentIndex = $_SESSION['current_index'];

// Consulta SQL corregida para obtener la información del registro actual, ordenada por niveles
$sql = "SELECT 
            pe.id AS performance_id, 
            ce.nombre AS concurso, 
            i.nombre AS institucion, 
            i.logo_path AS logo, 
            a.nombre AS alumno, 
            p.nombre AS profesor_nombre, 
            ins.id AS instancia, 
            a.nivel_id AS nivel, 
            pe.tiempo_deletreo AS tiempo_deletreo, 
            pe.tiempo_oracion AS tiempo_oracion, 
            pe.tiempo_final AS tiempo_final,
            pe.penalizacion_deletreo AS penalizacion_deletreo,
            pe.penalizacion_oracion AS penalizacion_oracion,
            pe.penalizaciones_totales AS penalizaciones,
            pe.descalificados AS descalificados
        FROM performance pe
        JOIN alumnos a ON pe.alumno_id = a.id
        JOIN instituciones i ON a.institucion_id = i.id
        JOIN profesores p ON a.profesor_id = p.id
        JOIN instancias ins ON pe.instancia_id = ins.id
        JOIN certamenes ce ON ins.certamen_id = ce.id
        ORDER BY ins.id ASC, a.nivel_id ASC 
        LIMIT 20 OFFSET $currentIndex";

$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $performance_id = $row['performance_id'];
    $concurso = $row['concurso'];
    $institucion = $row['institucion'];
    $logo = $row['logo'];
    $alumno = $row['alumno'];
    $profesor = $row['profesor_nombre'];
    $instance = $row['instancia'];
    $nivel = $row['nivel'];
    $tiempo_final = $row['tiempo_final'];
    $penalizaciones = $row['penalizaciones'];
    $descalificados = $row['descalificados'];

    // Valores específicos para nivel 3
    $tiempo_deletreo = $row['tiempo_deletreo'] ?? '00:00';
    $penalizacion_deletreo = $row['penalizacion_deletreo'] ?? 0;
    $tiempo_oracion = $row['tiempo_oracion'] ?? '00:00';
    $penalizacion_oracion = $row['penalizacion_oracion'] ?? 0;

    $deshabilitarBotones = $tiempo_final > '00:00';
} else {
    $concurso = "No data";
    $institucion = "No data";
    $logo = "images/logoinstitucion/default.png";
    $alumno = "No data";
    $profesor = "No data";
    $instance = "N/A";
    $nivel = "N/A";
    $tiempo_final = "00:00";
    $penalizaciones = 0;
    $descalificados = 0;

    // Valores por defecto para nivel 3
    $tiempo_deletreo = '00:00';
    $penalizacion_deletreo = 0;
    $tiempo_oracion = '00:00';
    $penalizacion_oracion = 0;

    $deshabilitarBotones = false;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronómetro</title>
    <link rel="icon" href="./styles/images/icon.png">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/eventos.css"> <!-- Estilos CSS -->
</head>

<body>
<!-- Header -->
<header class="header">
    <div class="header-logo"><img src="./styles/images/logo.png" alt=""></div>
    <!-- <div class="header-title"></div> -->
    <div class="header-sign">
    <a href="./verificacion.php">
        <button class="button_login">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.8" stroke="#666" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
          <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
          <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
        </svg>
        </button>
    </a>
    </div>
    <div class="header-sign">
        <a href="./index.html">
            <button class="button_login">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.8" stroke="#fb0" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
              <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
              <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>
            </button>
        </a>
    </div>
</header>
<!-- Data Section -->
<section>
    <div class="contenedor">
        <h4 id="Titulo">Escuela Técnica "Carmen Molina de Llano"</h4>
    </div>
    <div class="certamen">
        <h1 id="banner"><?php echo $concurso; ?></h1>
    </div>
    <div class="container">
        <div class="info" id="">
            <div class="logo">
                <img src="<?php echo $logo; ?>" alt="Logo de la Institución">
            </div>
            <div class="info">
                <div class="etiqueta">Institución: </div>
                <div class="nombre"><?php echo $institucion; ?></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="info" id="participante">
            <div class="etiqueta">Alumno/a:</div>
            <div class="nombre"><?php echo $alumno; ?></div>
            <div class="etiqueta">Referente:</div>
            <div class="nombre"><?php echo $profesor; ?> </div>
        </div>
    </div>
    <!-- Sección específica para nivel 3 -->
    <div class="container">
        <div class="info" id="level3">
            <div class="etiqueta">Tiempo:</div>
            <div class="nombre"><?php echo $tiempo_deletreo; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_deletreo; ?> </div>
            <!-- <div class="etiqueta">Oración:</div>
            <div class="nombre"><?php echo $tiempo_oracion; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_oracion; ?> </div> -->
        </div>
    </div>
</section>

<section class="main-container" id="deleted-container">
    <div class="sub-main-container level-container">
        <div class="sub-tittle level-title">Level</div>
        <div class="sub-value level-value"><?php echo $nivel; ?></div>
    </div>
    <div class="sub-main-container round-container">
        <div class="sub-tittle round-title">Round</div>
        <div class="sub-value round-value"><?php echo $instance; ?></div>
    </div>
    <div id="cronometro"><?php 
    if ($nivel == 3){
        // echo $tiempo_final;
        echo $tiempo_deletreo;
    }else{
        echo $tiempo_deletreo;  
    };?></div>
    <div class="sub-main-container penalty-container">
        <div class="sub-tittle penalty-title">Penalty</div>
        <div class="sub-value penalty-value"><?php echo $penalizaciones; ?></div>
    </div>
    <div class="sub-main-container time-container">
        <div class="sub-tittle time-title">Time</div>
        <div class="sub-value time-value">45"</div>
    </div>
</section>
<section id="botones">
    <button id="startStop" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Start</button>
    <button id="reset" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Reset</button>
    <button id="penaltyM" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P -</button>
    <button id="penaltyP" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P +</button>
    <button id="guardar" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Guardar</button>
    <button id="prev" class="boton-estilo">Anterior</button>
    <button id="next" class="boton-estilo">Siguiente</button>
    <button id="ranking" class="boton-estilo">Ranking</button>
    <button id="delete" class="boton-estilo">Disqualify</button>
    <button id="audio" class="boton-estilo">Audio</button>
</section>
<h4 id="deleted"><?php if ($descalificados == 1 || $descalificados == true) {
        echo "DISQUALIFIED";
        echo "<script>document.getElementById('deleted-container').style.display = 'none'</script>";
    }else{
        echo "<script>document.getElementById('deleted').style.display = 'none'</script>";
    } ?></h4>
<!-- Bootstrap JS y jQuery (para el funcionamiento de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Variables globales
        let firstSavedTime;
        let secondSavedTime;
        let timer;
        let timer2;
        let running = false;
        let startTime;
        let startSecondTime;
        let elapsedTime = 0;
        let elapsedSecondTime = 0;
        let penaltyValue = 0;
        let secondPenaltyValue = 0;
        let startedTime = false;
        let reseted = false;
        let saved = false;
        let level = <?php echo isset($nivel) ? json_encode($nivel) : 'null'; ?>;
        let descalificado = <?php echo isset($descalificados) ? json_encode($descalificados) : 0 ?>;
        let idActual = <?php echo $row['performance_id'] ?>;
        console.log('Level: ' + level);
        // Función para habilitar/deshabilitar botones
        function togglePenaltyButton(enable) {
            document.getElementById("penaltyP").disabled = !enable;
            // document.getElementById("guardar").disabled = !enable;
        };
        if (running) {
            document.getElementById("penaltyP").disabled = !enable;
            document.getElementById("penaltyM").disabled = !enable;
            document.getElementById("guardar").disabled = !enable;
            document.getElementById("next").disabled = !enable;
            document.getElementById("prev").disabled = !enable;
            document.getElementById("ranking").disabled = !enable;
        }
        function descalificar(idActual) {
            console.log(idActual); // Asegúrate de usar el nombre correcto
            if (confirm("¿Estás seguro de que deseas descalificar a este participante?")) {
                fetch('./guardarDescalificados.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${idActual}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Mensaje de éxito o error
                        location.reload(); // Recargar la página para reflejar los cambios
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
        function iniciarCronometro() {
            if (!running) {
                if (level == 3 && false) {
                    if (startedTime) {
                        // Inicia el segundo cronómetro
                        running = true;
                        startSecondTime = Date.now() - elapsedSecondTime;
                        timer2 = setInterval(actualizarSegundoCronometro, 10);
                        document.getElementById('cronometro').style.backgroundColor = 'green';
                    } else {
                        // Inicia el primer cronómetro
                        running = true;
                        startTime = Date.now() - elapsedTime;
                        timer = setInterval(actualizarCronometro, 10);
                    }
                    togglePenaltyButton(false);
                    console.log("startedTime:", startedTime);
                    startedTime = !startedTime;
                    console.log("startedTime:", startedTime);
                } else {
                    // Manejo para niveles diferentes a 3
                    running = true;
                    startTime = Date.now() - elapsedTime;
                    timer = setInterval(actualizarCronometro, 10);
                    togglePenaltyButton(false);
                }
                reseted = false;
            }
        }
        function detenerCronometro() {
            running = false;
            clearInterval(timer);
            clearInterval(timer2);
            if (false && level == 3 && startedTime) {
                elapsedTime = Date.now() - startTime; // Verifica esto                    
                firstSavedTime = elapsedTime
            } else {
                elapsedTime = Date.now() - startTime;
            }
            togglePenaltyButton(true);
        }
        function reiniciarCronometro() {
            if (!running) {
                if (false) {
                    running = false;
                    clearInterval(timer2);
                    elapsedSecondTime = 0;
                    secondPenaltyValue = 0;
                } else {
                    running = false;
                    clearInterval(timer);
                    elapsedTime = 0;
                    penaltyValue = 0;
                }
                document.querySelector(".penalty-value").innerText = penaltyValue;
                document.getElementById("cronometro").innerText = "00:00";
                reseted = true;
                togglePenaltyButton(false);
            }
        }
        function actualizarCronometro() {
            if (running) {
                elapsedTime = Date.now() - startTime;
            }
            const penalizaciones = 5 * penaltyValue
            const totalSeconds = (elapsedTime / 1000) + penalizaciones;
            const displaySegundos = Math.floor(totalSeconds).toString().padStart(2, '0');
            const displayMilisegundos = Math.floor((totalSeconds - Math.floor(totalSeconds)) * 100).toString().padStart(2, '0');
            const cronometro = `${displaySegundos}.${displayMilisegundos}`;
            document.getElementById("cronometro").innerText = cronometro.replace(".", ":");
        };
        function formatTime(totalSeconds) {
            const secs = Math.floor(totalSeconds);
            const ms = Math.floor((totalSeconds - secs) * 100);
            const displaySegundos = secs.toString().padStart(2, '0');
            const displayMilisegundos = ms.toString().padStart(2, '0');
            console.log('TotalSeconds ' + totalSeconds);
            console.log(`${displaySegundos}.${displayMilisegundos}`);
            return `${displaySegundos}.${displayMilisegundos}`;
        };
        document.getElementById("deleted").addEventListener("click", function() {
            descalificar(idActual);
        });
        document.getElementById("startStop").addEventListener("click", function() {
            if (running) {
                detenerCronometro();
                this.innerText = "Start";
                console.log('Timer: ' + timer);
                console.log('StartTime: ' + startTime);
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
                if (level == 3 && !startedTime && false) {
                    secondPenaltyValue += 1;
                    const cronometro = (elapsedSecondTime / 1000) + secondPenaltyValue * 5;
                    const secondSavedTime = cronometro;
                    document.querySelector(".penalty-value").innerText = secondPenaltyValue;
                    document.getElementById("cronometro").innerText = formatSecondTime(cronometro);
                    console.log(cronometro);
                } else {
                    penaltyValue += 1;
                    const cronometro = (elapsedTime / 1000) + penaltyValue * 5;
                    document.querySelector(".penalty-value").innerText = penaltyValue;
                    document.getElementById("cronometro").innerText = formatTime(cronometro);
                    console.log(cronometro);
                }
            }
        });
        document.getElementById("penaltyM").addEventListener("click", function() {
            if (penaltyValue > 0) {
                if (false && level == 3 && startedTime) {
                    secondPenaltyValue -= 1;
                    const cronometro = (elapsedSecondTime / 1000) + secondPenaltyValue * 5;
                    document.querySelector(".penalty-value").innerText = secondPenaltyValue;
                    document.getElementById("cronometro").innerText = formatSecondTime(cronometro);
                    console.log(cronometro);
                } else {
                    penaltyValue -= 1;
                    const cronometro = (elapsedTime / 1000) + penaltyValue * 5;
                    document.querySelector(".penalty-value").innerText = penaltyValue;
                    document.getElementById("cronometro").innerText = formatTime(cronometro);
                    console.log(cronometro);
                }
            }
        });
        document.getElementById("deleted").addEventListener("click", function() {
            if (!running) {
            }
        });
        document.getElementById("guardar").addEventListener("click", function() {
            if (!running) {
                const finalTime = (elapsedTime / 1000) + penaltyValue * 5;
                const formattedTime = formatTime(finalTime);
                console.log('finalTime: ' + finalTime)
                console.log('formattedTime: ' + formattedTime);
                fetch('guardar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        performance_id: <?php echo json_encode($performance_id); ?>,
                        tiempo_deletreo: formattedTime,
                        penalizacion_deletreo: penaltyValue,
                    })
                })
                .then(response => response.text())
                .then(text => {
                    console.log('Respuesta del servidor:', text);
                    return JSON.parse(text);
                })
                .then(data => {
                    if (data.success) {
                        console.log(data);
                        saved = true;
                        alert('Datos guardados exitosamente');
                    } else {
                        console.log(data);
                        alert('Error al guardar los datos: ' + data.error);
                    }
                }).catch(error => {
                    console.error('Error al procesar la solicitud:', error);
                    alert('Error al procesar la solicitud');
                });
            }

        });
        document.addEventListener("keydown", function(event) {
            if ((event.key === " " || event.key === "Spacebar") && event.target.tagName !== "INPUT" && event.target.tagName !== "TEXTAREA") {
                event.preventDefault();
                console.log('Acabas de apretar: Spacebar');
                document.getElementById("startStop").click();
            } else if (event.key === "Enter") {
                reiniciarCronometro();
                console.log('Acabas de apretar: R');
                document.getElementById("startStop").innerText = "Start";
            } else if (event.key === "ArrowLeft") {
                event.preventDefault();
                console.log('Acabas de apretar: <-');
                document.getElementById("prev").click();
            } else if (event.key === "ArrowRight") {
                event.preventDefault();
                console.log('Acabas de apretar: ->');
                document.getElementById("next").click();
            } else if (event.key === "G" || event.key === "g") {
                event.preventDefault();
                console.log('Acabas de apretar: G');
                document.getElementById("siguienteInstancia").click();
            } else if (event.key === "+" || event.key === "-") {
                console.log('Acabas de apretar: + OR -');
                document.getElementById(event.key === "+" ? "penaltyP" : "penaltyM").click();
            } else if (event.key === "s" || event.key === "S") {
                console.log('Acabas de apretar: S');
                if (!document.getElementById("guardar").hasAttribute("disabled")) {
                    document.getElementById("guardar").click();
                }
            } else if (event.key === "r" || event.key === "R") {
                console.log('Acabas de apretar: R');
                window.location.href = `ranking.php?nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>`;
            } else if (event.key === "f" || event.key === "F"){
                console.log('Acabas de apretar: F');
                document.getElementById("deleted").click();
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
        });
        togglePenaltyButton(false); // Deshabilitar botón P+ y botón de guardar al cargar la página
    });
</script>
</body>
</html>