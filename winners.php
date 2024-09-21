<?php
include './conexion.php';
session_start();

$evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
// echo $evento;
if ($evento == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}
$sql = "SELECT pa.id_participante AS id_participante, i.nombre AS institucion, i.logo AS logo, a.nombre AS alumno, pa.nivel AS nivel, pa.instancia_alcanzada AS instancia, pa.tiempo_deletreo AS tiempo_deletreo, pa.tiempo_oracion AS tiempo_oracion, pa.tiempo_total AS tiempo_total, pa.penalizacion_deletreo AS penalizaciones, pa.fallo AS descalificado
        FROM participantes pa
        JOIN alumnos a ON pa.id_alumno = a.id_alumno
        JOIN instituciones i ON a.id_institucion = i.id_institucion
        WHERE pa.id_evento = $evento AND pa.fallo = 0 AND pa.instancia_alcanzada = 4
        ORDER BY tiempo_total ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_participante = $row['id_participante'];
    $nombre = $row['alumno'];
    $nivel = $row['nivel'];
    $tiempo_total = $row['tiempo_total'];
    $institucion = $row['institucion'];
    $logo = $row['logo'];
}else{
    echo "no se encontraron alumno";
    $row = $result->fetch_assoc();
    $concurso = $row['evento'];
    $id_participante = $row['id_participante'];
    $nombre = $row['alumno'];
    $nivel = 0;
    $logo = "predeterminado";
}
// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/winners.css">
    <title>Ganadores</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>
<body>
    <h1>Ganadores - Mejores Tiempos</h1>

    <h2>Nivel 1</h2>
    <table class="ganadores-table">
        <thead>
            <tr>
                <th>Deletreo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($nivel == 1) {
                while ($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . ($nombre ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <h2>Nivel 2</h2>
    <table class="ganadores-table">
        <thead>
            <tr>
                <th>Deletreo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($nivel == 2) {
                for ($i = 0; $i < 2; $i++) {
                    echo "<tr>";
                    echo "<td>" . ($nombre[$i] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <h2>Nivel 3</h2>
    <table class="ganadores-table">
        <thead>
            <tr>
                <th>Deletreo</th>
                <th>Oración</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($nivel == 3) {
                for ($i = 0; $i < 2; $i++) {
                    echo "<tr>";
                    echo "<td>" . ($nombre[$i] ?? 'N/A') . "</td>";
                    echo "<td>" . ($nombre[$i] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Botón para imprimir y guardar como imagen -->
    <button class="btn-imprimir" onclick="imprimirComoImagen()">Imprimir y Guardar</button>

    <footer>
        © 2024 Concurso de Deletreo y Oración
    </footer>

    <script>
        function imprimirComoImagen() {
            html2canvas(document.body, {
                onrendered: function(canvas) {
                    let enlaceDescarga = document.createElement('a');
                    enlaceDescarga.href = canvas.toDataURL("image/png");
                    enlaceDescarga.download = 'ganadores.png';
                    enlaceDescarga.click();
                }
            });
        }
    </script>
</body>
</html>
