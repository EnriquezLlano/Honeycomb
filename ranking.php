<?php
include 'conexion.php';
session_start();

// Obtener los parámetros del nivel y la instancia
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : "N/A";
$instanciaActual = isset($_GET['instancia']) ? $_GET['instancia'] : "N/A";

// Consulta SQL para obtener el ranking de la performance del nivel y la instancia
$sql = "SELECT pe.id AS performance_id, i.nombre AS institucion, a.nombre AS alumno, pe.tiempo AS tiempo_final, pe.penalizacion AS penalizaciones
        FROM performance pe
        JOIN alumnos a ON pe.alumno_id = a.id
        JOIN instituciones i ON a.institucion_id = i.id
        JOIN instancias ins ON pe.instancia_id = ins.id
        WHERE a.nivel_id = '$nivel' AND ins.id = '$instanciaActual'
        ORDER BY tiempo_final ASC";
$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/ranking.css">
    <link rel="shortcut icon" href="./styles/images/icon.png" type="image/x-icon">
    <title>Ranking</title>
</head>
<body>

<div class="container centered-text">
    <h4 class="h4">Escuela Técnica "Carmen Molina de Llano"</h4>
    <div>
        <div class="info_ranking">
            <strong>Instancia:</strong> <span class="large-text"><?php echo $instanciaActual; ?></span>
        </div>
        <div class="info_ranking">
            <strong>Nivel:</strong> <span class="large-text"><?php echo $nivel; ?></span>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Puesto</th>
                    <th scope="col">Institución</th>
                    <th scope="col">Alumno</th>
                    <th scope="col">Tiempo</th>
                    <th scope="col">Penalización</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $puesto = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $puesto . '</td>';
                        echo '<td>' . $row['institucion'] . '</td>';
                        echo '<td>' . $row['alumno'] . '</td>';
                        echo '<td>' . $row['tiempo_final'] . '</td>';
                        echo '<td>' . $row['penalizaciones'] . '</td>';
                        echo '</tr>';
                        $puesto++;
                    }
                } else {
                    echo '<tr><td colspan="5">No hay datos disponibles.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="container button-container">
    <button id="backToEvents" class="btn" onclick="window.location.href='eventos.php';">Volver a Eventos</button>
</div>

<!-- <img class="rafiki" src="./styles/images/winners-rafiki.svg" alt="winners"> -->

<script>
    // Añadir event listener para la tecla "R"
    document.addEventListener("keydown", function(event) {
        if (event.key === "r" || event.key === "R") {
            document.getElementById("backToEvents").click();
        }
    });
</script>

</body>
</html>