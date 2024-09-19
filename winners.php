<?php
include './conexion.php';
session_start();

// Obtener los parámetros del nivel y la instancia
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : "N/A";
$instanciaActual = isset($_GET['instancia']) ? $_GET['instancia'] : "N/A";
$evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
// echo $evento;
if ($evento == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}
// Consulta SQL para obtener el ranking de la performance del nivel y la instancia
$sql = "SELECT pa.id_participante AS id_participante, i.nombre AS institucion, a.nombre AS alumno, pa.tiempo_deletreo AS tiempo_deletreo, pa.tiempo_oracion AS tiempo_oracion, pa.penalizacion_deletreo AS penalizaciones, pa.fallo AS descalificado
        FROM participantes pa
        JOIN alumnos a ON pa.id_alumno = a.id_alumno
        JOIN instituciones i ON a.id_institucion = i.id_institucion
        WHERE pa.id_evento = $evento AND pa.nivel = '$nivel' AND pa.instancia_alcanzada = '$instanciaActual'
        ORDER BY descalificado ASC, tiempo_deletreo ASC";
$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganadores</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            /* background-color: #FFF9C4; */
            background-color: #FFF8DC;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: #000;
            background-color: #FFF;
            padding: 10px 20px;
            border-radius: 15px;
            font-size: 36px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            border: 3px solid #000;
            display: inline-block;
        }

        h2 {
            color: #000;
            margin: 20px 0;
            text-shadow: 1px 1px 1px #333;
            font-size: 24px;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 60%;
            /* background-color: #FFF8DC; */
            background-color: #FFF9C4;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        th, td {
            border: 2px solid #000; /* Borde negro para las celdas */
            padding: 15px;
            text-align: center;
            color: #000;
        }

        th {
            background-color: #FFDD57;
            color: #000;
            font-size: 18px;
        }

        td {
            font-size: 16px;
            background-color: #FFF; /* Fondo blanco para las celdas */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #FFDD57;
            color: #333;
        }

        /* Estilo para la sección de ganadores */
        .ganadores-table {
            border: 3px solid #000; /* Borde negro para toda la tabla de ganadores */
            border-radius: 15px;
            background-color: #333333; /* Fondo blanco para las celdas de ganadores */
        }

        .ganadores-table th {
            background-color: #FFDD57;
        }

        .ganadores-table td {
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            color: #555;
            font-size: 14px;
        }

        /* Estilo del botón imprimir */
        .btn-imprimir {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #000;
            color: #FFF;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-imprimir:hover {
            background-color: #333;
        }
    </style>
    <!-- Incluir la biblioteca html2canvas para capturar la vista como imagen -->
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
            for ($i = 0; $i < 2; $i++) {
                echo "<tr>";
                echo "<td>" . ($mejoresDeletreoNivel1[$i] ?? 'N/A') . "</td>";
                echo "</tr>";
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
            for ($i = 0; $i < 2; $i++) {
                echo "<tr>";
                echo "<td>" . ($mejoresDeletreoNivel2[$i] ?? 'N/A') . "</td>";
                echo "</tr>";
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
            for ($i = 0; $i < 2; $i++) {
                echo "<tr>";
                echo "<td>" . ($mejoresDeletreoNivel3[$i] ?? 'N/A') . "</td>";
                echo "<td>" . ($mejoresOracionNivel3[$i] ?? 'N/A') . "</td>";
                echo "</tr>";
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
                    // Crear un enlace de descarga
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
