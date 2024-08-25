<?php
// Conexión a la base de datos
require './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de solicitud POST para guardar instancias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['selected'])) {
        $selectedIds = $data['selected'];

        foreach ($selectedIds as $performance_id) {
            // Obtener los datos actuales de la fila seleccionada
            $query = "SELECT * FROM performance WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $performance_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                // Insertar una nueva fila con la instancia incrementada
                $new_instance = $row['instancia_id'] + 1; // Aumentar la instancia
                $query = "INSERT INTO performance (alumno_id, nivel_id, instancia_id, tiempo_deletreo, penalizacion_deletreo) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiiss", $row['alumno_id'], $row['nivel_id'], $new_instance, $row['tiempo_deletreo'], $row['penalizacion_deletreo']);
                $stmt->execute();
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se seleccionaron participantes.']);
    }
    exit();
}

// Obtener los parámetros de la solicitud AJAX para la tabla
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';
$instancia = isset($_GET['instancia']) ? $_GET['instancia'] : '';

// Construir la consulta SQL con los filtros aplicados
$sql = "SELECT alumnos.id as alumno_id, alumnos.nombre, performance.id as performance_id, performance.tiempo_deletreo, performance.penalizacion_deletreo, alumnos.nivel_id, performance.instancia_id
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
$sql .= " ORDER BY CAST(performance.tiempo_deletreo AS UNSIGNED) ASC";

$result = $conn->query($sql);

// Generar el contenido de la tabla basado en la consulta
$tableRows = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>";
        $tableRows .= "<td>" . $row["nombre"] . "</td>";
        $tableRows .= "<td>" . $row["tiempo_deletreo"] . "</td>";
        $tableRows .= "<td>" . $row["penalizacion_deletreo"] . "</td>";
        $tableRows .= "<td>" . $row["nivel_id"] . "</td>";
        $tableRows .= "<td>" . $row["instancia_id"] . "</td>";
        $tableRows .= "<td><input type='checkbox' name='select[]' value='" . $row["performance_id"] . "'></td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows = "<tr><td colspan='6'>No se encontraron participantes</td></tr>";
}

// Si es una solicitud AJAX, devolver solo las filas de la tabla
if (isset($_GET['ajax'])) {
    echo $tableRows;
    exit();
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
            
            // Hacer una solicitud al servidor con los filtros seleccionados
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?nivel=' + nivel + '&instancia=' + instancia + '&ajax=1', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Reemplazar el contenido de la tabla con el nuevo contenido
                    tableBody.innerHTML = xhr.responseText;
                } else {
                    console.error("Error al cargar los datos de la tabla.");
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
