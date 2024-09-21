<?php
require 'conexion.php';
session_start();

// Obtener el índice actual
if (!isset($_SESSION['current_index'])) {
    $_SESSION['current_index'] = 0;
}
$currentIndex = $_SESSION['current_index'];

$evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
// echo $evento;
if ($evento == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}
$sql = "SELECT 
            e.nombre_evento AS evento, 
            i.nombre AS institucion, 
            i.logo AS logo, 
            a.nombre AS alumno,
            pr.nombre AS profesor_nombre, 
            pa.id_participante AS id_participante,
            pa.instancia_alcanzada AS instancia_alcanzada, 
            pa.nivel AS nivel,
            pa.id_evento AS id_evento, 
            pa.tiempo_deletreo AS tiempo_deletreo, 
            pa.tiempo_oracion AS tiempo_oracion,
            pa.penalizacion_deletreo AS penalizacion_deletreo,
            pa.penalizacion_oracion AS penalizacion_oracion,
            pa.fallo AS descalificados
        FROM participantes pa
        JOIN alumnos a ON pa.id_alumno = a.id_alumno
        JOIN instituciones i ON a.id_institucion = i.id_institucion
        JOIN profesores pr ON a.id_profesor = pr.id_profesor
        JOIN eventos e ON pa.id_evento = e.id_evento
        WHERE pa.id_evento = $evento
        ORDER BY pa.instancia_alcanzada ASC, pa.nivel ASC, pa.id_participante
        LIMIT 20 OFFSET $currentIndex";

$result = $conn->query($sql);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $concurso = $row['evento'];
    $institucion = $row['institucion'];
    $logo = $row['logo'];
    $alumno = $row['alumno'];
    $profesor = $row['profesor_nombre'];
    $id_participante = $row['id_participante'];
    $instance = $row['instancia_alcanzada'];
    $nivel = $row['nivel'];
    $descalificados = $row['descalificados'];

    // Valores específicos para nivel 3
    $tiempo_deletreo = $row['tiempo_deletreo'] ?? '00:00';
    $tiempo_oracion = $row['tiempo_oracion'] ?? '00:00';
    // $tiempo_total = $row['tiempo_total'] ?? '00:00';
    $penalizacion_deletreo = $row['penalizacion_deletreo'] ?? 0;
    $penalizacion_oracion = $row['penalizacion_oracion'] ?? 0;

    $deshabilitarBotones = $tiempo_deletreo > '00:00';
} else {
    $concurso = "No data";
    $institucion = "No data";
    $logo = "images/logoinstitucion/default.png";
    $alumno = "No data";
    $profesor = "No data";
    $instance = "N/A";
    $nivel = "N/A";
    $descalificados = 0;

    // Valores por defecto para nivel 3
    $tiempo_deletreo = '00:00';
    $tiempo_oracion = '00:00';
    $penalizacion_deletreo = 0;
    $penalizacion_oracion = 0;

    $deshabilitarBotones = false;
}

$time1 = str_replace(':', '.', $tiempo_deletreo);
$time2 = str_replace(':', '.', $tiempo_oracion);
$tiempo_total_float = ((float)$time1 + 5 * $penalizacion_deletreo)+ ((float)$time2 + 5 * $penalizacion_oracion);
$tiempo_total = str_replace('.', ':', sprintf('%02d:%02d', floor($tiempo_total_float), ($tiempo_total_float * 100) % 100));

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
    <a href="./verificacion.php?id_evento=<?php echo $evento?>">
        <button class="button_instances">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-check" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#212121" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />
          <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" />
          <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />
          <path d="M11 6l9 0" />
          <path d="M11 12l9 0" />
          <path d="M11 18l9 0" />
        </svg>
        </button>
    </a>
    </div>
    <div class="header-sign">
        <a href="./index.html">
            <button class="button_index">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.8" stroke="#212121" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
    <div class="certamen">
        <h1 id="banner"><?php echo $concurso; ?></h1>
    </div>
    <div class="container">
        <div class="info" id="">
            <div class="info">
                <div class="etiqueta">Institución: </div>
                <div class="nombre"><?php echo $institucion; ?></div>
            </div>
            <div class="logo">
                <img src="./styles/images/logoInstitucion/<?php echo $logo; ?>" alt="Logo de la Institución">
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
    <div class="container">
        <div class="info" id="level3">
            <div class="etiqueta">Tiempo:</div>
            <div class="nombre"><?php echo $tiempo_deletreo; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_deletreo; ?> </div>
            <div class="etiqueta">Oración:</div>
            <div class="nombre"><?php echo $tiempo_oracion; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_oracion; ?> </div>
        </div>
    </div>
</section>

<section class="main-container" id="main-container">
    <div class="sub-main-container level-container">
        <div class="sub-tittle level-title">Level</div>
        <div class="sub-value-container">
          <div class="sub-value-border"></div>
          <div class="sub-value"><?php echo $nivel; ?></div>
        </div>
    </div>
    <div class="sub-main-container round-container">
        <div class="sub-tittle round-title">Round</div>
        <div class="sub-value-container">
          <div class="sub-value-border"></div>
          <div class="sub-value"><?php echo $instance; ?></div>
        </div>
    </div>
    <div id="cronometro"><?php 
    if ($nivel == 3){
        echo $tiempo_total;
    }else{
        echo $tiempo_deletreo;  
    };?></div>
    <div class="sub-main-container penalty-container">
        <div class="sub-tittle penalty-title">Penalty</div>
        <div class="sub-value-container">
          <div class="sub-value-border"></div>
          <div class="sub-value penalty-value"><?php echo $penalizacion_deletreo; ?></div>
        </div>
    </div>
    <div class="sub-main-container time-container">
        <div class="sub-tittle time-title">Time</div>
        <div class="sub-value-container">
          <div class="sub-value-border"></div>
          <div class="sub-value"><?php echo ($instance == 1) ? '60"' : '45"' ;?></div>
        </div>
    </div>
</section>
<section id="botones">
    <button id="startStop" class="boton-estilo" >Start</button>
    <button id="reset" class="boton-estilo">Reset</button>
    <button id="penaltyM" class="boton-estilo">P -</button>
    <button id="penaltyP" class="boton-estilo">P +</button>
    <button id="guardar" class="boton-estilo">Guardar</button>
    <button id="prev" class="boton-estilo">Anterior</button>
    <button id="next" class="boton-estilo">Siguiente</button>
    <button id="ranking" class="boton-estilo">Ranking</button>
    <button id="delete" class="boton-estilo">Disqualify</button>
    <button id="audio" class="boton-estilo">Audio</button>
</section>
<h4 id="deleted"><?php if ($descalificados == 1 || $descalificados == true) {
        echo "DISQUALIFIED";
        echo "<script>document.getElementById('main-container').style.display = 'none'</script>";
    }else{
        echo "<script>document.getElementById('deleted').style.display = 'none'</script>";
    } ?></h4>
<!-- Bootstrap JS y jQuery (para el funcionamiento de Bootstrap) -->
<script src="./js/boostrapSlimJs.js"></script>
<script src="./js/boostrapPoppeJs.js"></script>
<script src="./js/boostrapMinJs.js"></script>
<script>
    console.log(<?php echo $evento; ?>);
    console.log(<?php echo $descalificados?>);
    let isRunning = false;
    let isDeletreoTime = true; 
    let startTime, elapsedTimeDeletreo = 0, elapsedTimeOracion = 0;
    let penalizacionDeletreo = <?php echo $penalizacion_deletreo; ?>;
    let penalizacionOracion = <?php echo $penalizacion_oracion; ?>;
    let interval;
    let idActual = <?php echo $id_participante;?>;
    let descalificado = <?php echo $descalificados;?>;

    // Iniciar o detener cronómetro
    function toggleCronometro() {
        if (!isRunning) {
            startTime = new Date().getTime();
            interval = setInterval(updateTime, 8);
            document.getElementById("startStop").innerText = isDeletreoTime ? "Stop Deletreo" : "Stop Oración";
            isRunning = true;
        } else {
            clearInterval(interval);
            let elapsedTime = new Date().getTime() - startTime;
            if (isDeletreoTime) {
                elapsedTimeDeletreo += elapsedTime;
                document.getElementById("cronometro").innerText = formatTime(elapsedTimeDeletreo);
                isDeletreoTime = false;
            } else {
                elapsedTimeOracion += elapsedTime;
                document.getElementById("cronometro").innerText = formatTime(elapsedTimeOracion);
                isDeletreoTime = true;
                document.getElementById("startStop").setAttribute("disabled", "true");
            }
            document.getElementById("startStop").innerText = "Start";
            isRunning = false;
        }
    }

    function updateTime() {
        // console.clear();
        // console.log("startTime: " + startTime);
        let currentTime = new Date().getTime() - startTime;
        // console.log("currentTime " + currentTime);
        console.log(isDeletreoTime ? "elapsedDeletro" + elapsedTimeDeletreo : "elapsedOracion" + elapsedTimeOracion);
        let totalElapsedTime = isDeletreoTime ? elapsedTimeDeletreo + currentTime : elapsedTimeOracion + currentTime;
        // console.log("totalElapsed" + totalElapsedTime);
        document.getElementById("cronometro").innerText = formatTime(totalElapsedTime);
    }

    function formatTime(time) {
        let ms = Math.floor(time % 1000 / 10);
        let seconds = Math.floor(time / 1000);
        return `${seconds < 10 ? '0' : ''}${seconds}:${ms < 10 ? '0' : ''}${ms}`;
    }

    // Asignar funcionalidad a los botones
    document.getElementById("startStop").addEventListener("click", toggleCronometro);
    document.getElementById("reset").addEventListener("click", function() {
        clearInterval(interval);
        isRunning = false;
        elapsedTimeDeletreo = 0;
        elapsedTimeOracion = 0;
        penalizacionDeletreo = 0;
        penalizacionOracion = 0;
        isDeletreoTime = true;
        document.getElementById("cronometro").innerText = "00:00";
        document.getElementById("startStop").innerText = "Start";
        document.getElementById("startStop").removeAttribute("disabled");
        updatePenalizacionDisplay();
    });

    document.getElementById("penaltyP").addEventListener("click", function() {
        if (!isDeletreoTime) {
            if (elapsedTimeDeletreo  > 0) {
                console.log("elapsedDeletreoP" + elapsedTimeDeletreo);
                penalizacionDeletreo += 1;
                // elapsedTimeDeletreo += 5000;
                console.log("elapsedDeletreoPP" + elapsedTimeDeletreo);   
            }
        } else {
            if (elapsedTimeOracion > 0) {
                console.log("elapsedOracionP" + elapsedTimeOracion);
                penalizacionOracion += 1;
                // elapsedTimeOracion += 5000;
                console.log("elapsedTimeOracionPP" + elapsedTimeOracion);
            }
        }
        updatePenalizacionDisplay();
    });
    
    document.getElementById("penaltyM").addEventListener("click", function() {
        if (penalizacionDeletreo > 0) {
            if (!isDeletreoTime) {
                console.log("elapsedDeletroM" + elapsedTimeDeletreo);
                penalizacionDeletreo -= 1;
                // elapsedTimeDeletreo -= 5000;
                console.log("elapsedDeletreoMM" + elapsedTimeDeletreo);
            } else{
                console.log("elapsedOracionM" + elapsedTimeOracion);
                penalizacionOracion -= 1;
                // elapsedTimeOracion -= 5000;
                console.log("elapsedOracionMM" + elapsedTimeOracion);
            }
            updatePenalizacionDisplay();   
        }
    });

    function updatePenalizacionDisplay() {
        document.querySelector('.penalty-value').innerText = !isDeletreoTime ? penalizacionDeletreo : penalizacionOracion;
        document.getElementById('cronometro').innerText = formatTime(!isDeletreoTime ? elapsedTimeDeletreo : elapsedTimeOracion);;
    }
    document.getElementById("delete").addEventListener("click", function(idActual) {
        console.log(idActual);
        let data = {
            id_participante: idActual,
            falo: descalificado 
        }
        if (confirm("¿Estás seguro de que deseas descalificar a este participante?")) {
            fetch('./guardarDescalificados.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        }
    });
    document.getElementById("guardar").addEventListener("click", function() {
        let formatedTimeDeletreoWithPenaltys = formatTime(elapsedTimeDeletreo + 5000 * penalizacionDeletreo);
        let formatedTimeOracionWithPenaltys = formatTime(elapsedTimeOracion + 5000 * penalizacionOracion);

        // const tiempo1 = formatedTimeDeletreoWithPenaltys;
        // const tiempo2 = formatedTimeOracionWithPenaltys;
        // const [segundos1, milisegundos1] = tiempo1.split(':').map(Number);
        // const [segundos2, milisegundos2] = tiempo2.split(':').map(Number);
        // const totalMilisegundos1 = (segundos1 * 1000) + milisegundos1;
        // const totalMilisegundos2 = (segundos2 * 1000) + milisegundos2;
        // console.log("milisegundos totales de deletreo: " + totalMilisegundos1);
        // console.log("milisegundos totales de oracion: " + totalMilisegundos2);
        // const milisegundosTotales = totalMilisegundos1 + totalMilisegundos2;
        // console.log(milisegundosTotales);

        // const tiempo_total = formatTime(milisegundosTotales);
        // console.log("tiempo_total_sumado: " + tiempo_total);
        // console.log("tiempo_total_formateado: " + formatTime((elapsedTimeDeletreo + 5000 * penalizacionDeletreo) + (elapsedTimeOracion + 5000 * penalizacionOracion)));

        let data = {
            id_participante: <?php echo $id_participante; ?>,
            tiempo_deletreo: formatTime(elapsedTimeDeletreo),
            tiempo_oracion: formatTime(elapsedTimeOracion),
            tiempo_total: formatTime((elapsedTimeDeletreo + 5000 * penalizacionDeletreo) + (elapsedTimeOracion + 5000 * penalizacionOracion)),
            penalizacion_deletreo: penalizacionDeletreo,
            penalizacion_oracion: penalizacionOracion
        };
    
        fetch("guardar_tiempos.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Datos guardados correctamente.");
                window.location.reload();
            } else {
                alert("Error al guardar los datos.");
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener("keydown", function(event) {
            if ((event.key === " " || event.key === "Spacebar") && event.target.tagName !== "INPUT" && event.target.tagName !== "TEXTAREA") {
                event.preventDefault();
                document.getElementById("startStop").click();
            } else if (event.key === "Enter") {
                document.getElementById("reset").click();
            } else if (event.key === "ArrowLeft") {
                event.preventDefault();
                document.getElementById("prev").click();
            } else if (event.key === "ArrowRight") {
                event.preventDefault();
                document.getElementById("next").click();
            } else if (event.key === "G" || event.key === "g") {
                event.preventDefault();
                document.getElementById("siguienteInstancia").click();
            } else if (event.key === "+" || event.key === "-") {
                document.getElementById(event.key === "+" ? "penaltyP" : "penaltyM").click();
            } else if (event.key === "s" || event.key === "S") {
                if (!document.getElementById("guardar").hasAttribute("disabled")) {
                    document.getElementById("guardar").click();
                }
            } else if (event.key === "r" || event.key === "R") {
                window.location.href = `ranking.php?id_evento=<?php echo $evento; ?>&nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>`;
            } else if (event.key === "f" || event.key === "F"){
                document.getElementById("delete").click();
            }
        });

        document.getElementById("prev").addEventListener("click", function() {
            window.location.href = "navigation.php?id_evento=<?php echo $evento; ?>&action=prev";
        });

        document.getElementById("next").addEventListener("click", function() {
            window.location.href = "navigation.php?id_evento=<?php echo $evento; ?>&action=next";
        });

        document.getElementById("ranking").addEventListener("click", function() {
            window.location.href = `ranking.php?id_evento=<?php echo $evento; ?>&nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>`;
        });

        // togglePenaltyButton(false);
    });
</script>
</body>
</html>