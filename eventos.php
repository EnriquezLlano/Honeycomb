<?php
require 'conexion.php';
session_start();

// Verificar la acción del botón
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'next') {
        $_SESSION['current_index']++;
    } elseif ($_GET['action'] == 'prev') {
        if ($_SESSION['current_index'] > 0) {
            $_SESSION['current_index']--;
        }
    }
}

// Obtener el índice actual y asegurarse de que no sea menor que 0
if (!isset($_SESSION['current_index'])) {
    $_SESSION['current_index'] = 0;
} elseif ($_SESSION['current_index'] < 0) {
    $_SESSION['current_index'] = 0;
}

// Calcular el total de registros
$totalRecordsResult = $conn->query("SELECT COUNT(*) AS total FROM performance pe JOIN alumnos a ON pe.alumno_id = a.id");
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Asegurarse de que el índice no exceda el número de registros
if ($_SESSION['current_index'] >= $totalRecords) {
    $_SESSION['current_index'] = $totalRecords - 1;
}

// Obtener el índice actual
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
            pe.tiempo AS tiempo_final, 
            pe.penalizacion AS penalizaciones,
            pe.tiempo_oracion, 
            pe.penalizacion_oracion
        FROM performance pe
        JOIN alumnos a ON pe.alumno_id = a.id
        JOIN instituciones i ON a.institucion_id = i.id
        JOIN profesores p ON a.profesor_id = p.id
        JOIN instancias ins ON pe.instancia_id = ins.id
        JOIN certamenes ce ON ins.certamen_id = ce.id
        ORDER BY a.nivel_id ASC
        LIMIT 1 OFFSET $currentIndex";

$result = $conn->query($sql);

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

    // Valores por defecto para nivel 3
    $tiempo_deletreo = '00:00';
    $penalizacion_deletreo = 0;
    $tiempo_oracion = '00:00';
    $penalizacion_oracion = 0;

    $deshabilitarBotones = false;
}
echo $instance;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronómetro</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/estilos.css"> <!-- Estilos CSS -->
    <style>
        .boton-estilo {
            background-color: #ffc107; /* Color amarillo */
            border: 1px solid black; /* Borde negro */
            border-radius: 12px; /* Bordes redondeados */
            padding: 10px 20px; /* Padding para el tamaño del botón */
            margin: 5px; /* Margen entre botones */
        }
    </style>
</head>
<body>

<div>
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
            <div class="etiqueta">Deletreo:</div>
            <div class="nombre"><?php echo $tiempo_deletreo; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_deletreo; ?> </div>
            <div class="etiqueta">Oración:</div>
            <div class="nombre"><?php echo $tiempo_oracion; ?></div>
            <div class="etiqueta">Penalización:</div>
            <div class="nombre"><?php echo $penalizacion_oracion; ?> </div>
        </div>
    </div>
</div>

<div class="main-container">
    <div class="level-container">
        <div class="level-title">Nivel</div>
        <div class="level-value"><?php echo $nivel; ?></div>
    </div>

    <div class="round-container">
        <div class="round-title">Round</div>
        <div class="round-value"><?php echo $instance; ?></div>
    </div>

    <div id="cronometro"><?php echo $tiempo_final; ?></div>
    <div class="penalty-container">
        <div class="penalty-title">Penalty</div>
        <div class="penalty-value"><?php echo $penalizaciones; ?></div>
    </div>

    <div class="time-container">
        <div class="time-title">Time</div>
        <div class="time-value">45"</div>
    </div>
</div>

<div id="botones">
    <button id="startStop" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Start</button>
    <button id="reset" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Reset</button>
    <button id="penaltyM" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P -</button>
    <button id="penaltyP" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>P +</button>
    <button id="guardar" class="boton-estilo" <?php echo $deshabilitarBotones ? 'disabled' : ''; ?>>Guardar</button>
    <button id="prev" class="boton-estilo">Anterior</button>
    <button id="next" class="boton-estilo">Siguiente</button>
    <button id="ranking" class="boton-estilo">Ranking</button>
</div>

<!-- Bootstrap JS y jQuery (para el funcionamiento de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="cronometro.js"></script>
<script>
    document.getElementById("prev").addEventListener("click", function() {
        window.location.href = "eventos.php?action=prev";
    });

    document.getElementById("next").addEventListener("click", function() {
        window.location.href = "eventos.php?action=next";
    });

    document.getElementById("ranking").addEventListener("click", function() {
        window.location.href = "ranking.php?nivel=<?php echo $nivel; ?>&instancia=<?php echo $instance; ?>";
    });

    document.getElementById("guardar").addEventListener("click", function() {
        const finalTime = tiempoFinal + penaltyValue * 5;  // Calcular el tiempo final con penalizaciones
        const formattedTime = formatTime(finalTime);  // Formatear el tiempo final
        
        // Continuar con el proceso de guardar los datos
        fetch('guardar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                performance_id: <?php echo $performance_id; ?>,
                tiempo: formattedTime,
                penalizaciones: penaltyValue
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Datos guardados exitosamente');
            } else {
                alert('Error al guardar los datos');
            }
        })
        .catch(error => {
            console.error('Error al procesar la solicitud:', error);
            alert('Error en la conexión con el servidor');
        });
    });
</script>

</body>
</html>
