<?php
// Conexión a la base de datos
require './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los parámetros de la solicitud AJAX
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';
$instancia = isset($_GET['instancia']) ? $_GET['instancia'] : '';

// Construir la consulta SQL con los filtros aplicados
$sql = "SELECT alumnos.id as alumno_id, alumnos.nombre, performance.id as performance_id, performance.tiempo, performance.penalizacion, alumnos.nivel_id
        FROM alumnos
        JOIN performance ON alumnos.id = performance.alumno_id";

// Aplicar filtros si se proporcionan
$filters = [];
if ($nivel) {
    $filters[] = "alumnos.nivel_id = '" . $conn->real_escape_string($nivel) . "'";
}
if ($instancia) {
    $filters[] = "performance.instancia = '" . $conn->real_escape_string($instancia) . "'";
}

if (!empty($filters)) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

// Ordenar por tiempo de menor a mayor
$sql .= " ORDER BY CAST(performance.tiempo AS UNSIGNED) ASC";

$result = $conn->query($sql);

// Generar el contenido de la tabla basado en la consulta
$tableRows = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>";
        $tableRows .= "<td>" . $row["nombre"] . "</td>";
        $tableRows .= "<td>" . $row["tiempo"] . "</td>";
        $tableRows .= "<td>" . $row["penalizacion"] . "</td>";
        $tableRows .= "<td>" . $row["nivel_id"] . "</td>";
        $tableRows .= "<td><input type='checkbox' name='select[]' value='" . $row["performance_id"] . "'></td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows = "<tr><td colspan='5'>No se encontraron participantes</td></tr>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Participantes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .filter-container {
            margin-bottom: 20px;
        }
        .filter-container select, .filter-container button {
            padding: 10px;
            margin-right: 10px;
        }
        table > h1, table > button, table > .filter-container{
            display: none;
        }
    </style>
</head>
<body>
    <h1>Lista de Participantes</h1>
    <form action="guardar.php" method="post">
        <!-- Contenedor para los filtros -->
        <div class="filter-container">
            <label for="nivel">Nivel:</label>
            <select id="nivel" name="nivel">
                <option value="">Todos</option>
                <option value="1">Nivel 1</option>
                <option value="2">Nivel 2</option>
                <option value="3">Nivel 3</option>
            </select>

            <label for="instancia">Instancia:</label>
            <select id="instancia" name="instancia">
                <option value="">Todas</option>
                <option value="1">Instancia 1</option>
                <option value="2">Instancia 2</option>
                <option value="3">Instancia 3</option>
            </select>

            <button type="button" onclick="filterResults()">Mostrar Cambios</button>
        </div>
        
        <!-- Tabla de participantes -->
        <table id="participant-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tiempo</th>
                    <th>Penalizaciones</th>
                    <th>Nivel</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody id="participant-table-body">
                <?php echo $tableRows; ?>
            </tbody>
        </table>
        <button type="submit">Guardar</button>
    </form>

    <script>
        function filterResults() {
            var nivel = document.getElementById('nivel').value;
            var instancia = document.getElementById('instancia').value;

            var tableBody = document.getElementById('participant-table');
            
            // Limpiar el contenido actual
            tableBody.innerHTML = '';

            // Hacer una solicitud al servidor con los filtros seleccionados
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?nivel=' + nivel + '&instancia=' + instancia, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    // Reemplazar el contenido de la tabla con el nuevo contenido
                    tableBody.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Cargar los datos iniciales cuando se carga la página
        // document.addEventListener('DOMContentLoaded', filterResults);
    </script>
</body>
</html>
