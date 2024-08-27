<?php
include 'conexion.php';
session_start();

// Obtener los parámetros del nivel y la instancia
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : "N/A";
$instanciaActual = isset($_GET['instancia']) ? $_GET['instancia'] : "N/A";

// Consulta SQL para obtener el ranking de la performance del nivel y la instancia
$sql = "SELECT pe.id AS performance_id, i.nombre AS institucion, a.nombre AS alumno, pe.tiempo_deletreo AS tiempo_final, pe.tiempo_oracion AS tiempo_oracion, pe.penalizacion_deletreo AS penalizaciones, pe.descalificados AS descalificado
        FROM performance pe
        JOIN alumnos a ON pe.alumno_id = a.id
        JOIN instituciones i ON a.institucion_id = i.id
        JOIN instancias ins ON pe.instancia_id = ins.id
        WHERE a.nivel_id = '$nivel' AND ins.id = '$instanciaActual'
        ORDER BY descalificado ASC, tiempo_final ASC";
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
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
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
                    <?php if ($nivel == 3) {
                        echo '<th>Oracion</th>';
                    } ?>
                    <th scope="col">Penalización</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $puesto = 1;
                    while ($row = $result->fetch_assoc()) {
                        $descalificados = $row['descalificado'];
                        echo '<tr>';
                        echo '<td>' . $puesto . '</td>';
                        echo '<td>' . $row['institucion'] . '</td>';
                        echo '<td>' . $row['alumno'] . '</td>';
                        echo '<td>' . $row['tiempo_final'] . '</td>';
                        if ($nivel == 3) {
                            echo '<td>' . $row['tiempo_oracion'] . '</td>';
                        };
                        echo '<td>' . $row['penalizaciones'] . '</td>';
                        if ($descalificados == 1 || $descalificados == true) {
                            echo '<td class="descalificados">X</td>';
                            echo '';
                        }
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
    <button id="printToExcel" class="btn" onclick="exportToExcel();">Imprimir</button>
</div>

<!-- <img class="rafiki" src="./styles/images/winners-rafiki.svg" alt="winners"> -->

<script>
    // Añadir event listener para la tecla "R"
    document.addEventListener("keydown", function(event) {
        if (event.key === "r" || event.key === "R") {
            document.getElementById("backToEvents").click();
        }
    });

    function exportToExcel() {
        // Datos adicionales que queremos agregar antes de la tabla
        var additionalData = [
            ["Escuela Técnica Carmen Molina de Llano"],
            ["Spelling Bee - Inter Curso 2024"],
            ["Instancia: " + "<?php echo $instanciaActual; ?>"],
            ["Nivel: " + "<?php echo $nivel; ?>"],
            [] // Línea en blanco antes de la tabla
        ];

        // Obtener la tabla
        var table = document.querySelector("table");
        var rows = table.querySelectorAll("tr");
        var tableData = [];

        // Recorrer cada fila de la tabla y extraer datos
        rows.forEach((row, rowIndex) => {
            var rowData = [];
            row.querySelectorAll("th, td").forEach(cell => {
                rowData.push(cell.innerText);
            });
            tableData.push(rowData);
        });

        // Combinar los datos adicionales con los datos de la tabla
        var data = additionalData.concat(tableData);

        // Crear una hoja de trabajo
        var ws = XLSX.utils.aoa_to_sheet(data);

        // Definir el rango de la tabla en la hoja de trabajo
        var range = XLSX.utils.decode_range(ws['!ref']);

        // Ajustar el ancho de las columnas "Institución" y "Alumno"
        ws['!cols'] = [
            { width: 10 },  // Ancho predeterminado para otras columnas
            { width: 35.6 },  // Ancho para "Institución"
            { width: 35.6 }   // Ancho para "Alumno"
        ];

        // Aplicar estilos de negrita, alineación y bordes
        for (var R = range.s.r; R <= range.e.r; ++R) {
            for (var C = range.s.c; C <= range.e.c; ++C) {
                var cell = ws[XLSX.utils.encode_cell({r: R, c: C})];
                if (!cell) continue;

                cell.s = cell.s || {};

                // Aplicar estilos específicos para el encabezado
                if (R === 5) { // Encabezado en la fila 6
                    cell.s.font = { bold: true };
                    cell.s.alignment = { horizontal: 'center', vertical: 'center' };
                } else {
                    // Aplicar centrado para todo el contenido
                    cell.s.alignment = { horizontal: 'center', vertical: 'center' };
                }

                // No centrar las columnas de "Institución" y "Alumno" (celdas de la columna 1 y 2)
                if (C === 1 || C === 2) {
                    cell.s.alignment = { horizontal: 'left', vertical: 'center' };
                }

                // Aplicar bordes a todas las celdas
                cell.s.border = {
                    top: { style: "thin", color: { rgb: "000000" } },
                    bottom: { style: "thin", color: { rgb: "000000" } },
                    left: { style: "thin", color: { rgb: "000000" } },
                    right: { style: "thin", color: { rgb: "000000" } }
                };
            }
        }

        // Crear un libro de trabajo y agregar la hoja de trabajo
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Ranking");

        // Generar el nombre del archivo usando nivel e instancia
        var filename = "InterCurso_Nivel_" + "<?php echo $nivel; ?>" + "_Instancia_" + "<?php echo $instanciaActual; ?>" + ".xlsx";

        // Exportar el libro de trabajo a un archivo Excel con el nombre dinámico
        XLSX.writeFile(wb, filename);
    }
</script>


</body>
</html>