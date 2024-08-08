<?php
// Conexión a la base de datos
require './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si la solicitud es POST (guardar datos)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['selected'])) {
        $selectedIds = $data['selected'];

        // Preparar la consulta para actualizar la instancia de los participantes
        $sql_update = "UPDATE performance SET instancia_id = instancia_id + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . $conn->error]);
            exit();
        }

        foreach ($selectedIds as $id) {
            $stmt->bind_param('i', $id);
            if (!$stmt->execute()) {
                echo json_encode(['success' => false, 'error' => 'Error al actualizar datos: ' . $stmt->error]);
                exit();
            }
        }

        $stmt->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Datos JSON no válidos o faltantes.']);
    }
    $conn->close();
    exit();
}

// Obtener los parámetros de la solicitud AJAX para la tabla
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';
$instancia = isset($_GET['instancia']) ? $_GET['instancia'] : '';

// Construir la consulta SQL con los filtros aplicados
$sql = "SELECT alumnos.id as alumno_id, alumnos.nombre, performance.id as performance_id, performance.tiempo, performance.penalizacion, alumnos.nivel_id, performance.instancia_id
        FROM alumnos
        JOIN performance ON alumnos.id = performance.alumno_id";

// Aplicar filtros si se proporcionan
$filters = [];
if ($nivel) {
    $filters[] = "alumnos.nivel_id = '" . $conn->real_escape_string($nivel) . "'";
}
if ($instancia) {
    $filters[] = "performance.instancia_id = '" . $conn->real_escape_string($instancia) . "'";
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
        $tableRows .= "<td>" . $row["instancia_id"] . "</td>";
        $tableRows .= "<td><input type='checkbox' name='select[]' value='" . $row["performance_id"] . "'></td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows = "<tr><td colspan='6'>No se encontraron participantes</td></tr>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Participantes</title>
    <link rel="stylesheet" href="./styles/verificacion.css">
</head>
<body>
    <h1 id="h1">Lista de Participantes</h1>
    <form id="data-form">
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

            <button id="filterButton" type="button" onclick="filterResults()">Mostrar Cambios</button>
        </div>
        
        <!-- Tabla de participantes -->
        <table id="participant-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tiempo</th>
                    <th>Penalizaciones</th>
                    <th>Nivel</th>
                    <th>Instancia</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody id="participant-table-body">
                <?php echo $tableRows; ?>
            </tbody>
        </table>
        <br>
        <button id="botonGuardar" type="button" onclick="guardarSeleccion()">Guardar</button>
    </form>

    <script>
        function filterResults() {
            var nivel = document.getElementById('nivel').value;
            var instancia = document.getElementById('instancia').value;

            var tableBody = document.getElementById('participant-table-body');
            
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

        function guardarSeleccion() {
            var checkboxes = document.querySelectorAll('input[name="select[]"]:checked');
            var selectedIds = Array.from(checkboxes).map(checkbox => checkbox.value);

            // Crear el objeto con los datos a enviar
            var data = {
                selected: selectedIds
            };
        
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Datos guardados correctamente.');
                        filterResults(); // Actualizar la tabla después de guardar
                    } else {
                        alert('Error al guardar datos: ' + response.error);
                    }
                }
            };
            xhr.send(JSON.stringify(data));
        }

    </script>
</body>
</html>
