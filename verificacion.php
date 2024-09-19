<?php
// Conexión a la base de datos
require './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$evento = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;
// echo $evento;
if ($evento == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}
// Manejo de solicitud POST para guardar instancias o actualizar el tiempo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['selected'])) {
        $selectedIds = $data['selected'];

        foreach ($selectedIds as $id_participante) {
            $query = "SELECT * FROM participantes WHERE id_participante = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_participante);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $new_instance = $row['instancia_alcanzada'] + 1;
                $resetedTime = '00:00';
                $query = "INSERT INTO participantes (id_alumno, id_evento, nivel, instancia_alcanzada, tiempo_deletreo, penalizacion_deletreo) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iiiiss", $row['id_alumno'], $evento, $row['nivel'], $new_instance, $resetedTime, $row['penalizacion_deletreo']);
                $stmt->execute();
            }
        }

        echo json_encode(['success' => true]);
    } elseif (isset($data['edit'])) {
        $id_participante = $data['id_participante'];
        $new_time = $data['new_time'];

        $query = "UPDATE participantes SET tiempo_deletreo = ? WHERE id_participante = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $new_time, $id_participante);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al guardar el nuevo tiempo.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No se seleccionaron participantes o no se proporcionó edición.']);
    }
    exit();
}

$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '';
$instancia = isset($_GET['instancia']) ? $_GET['instancia'] : '';

$sql = "SELECT alumnos.id_alumno as id_alumno, alumnos.nombre, participantes.id_participante as id_participante, participantes.tiempo_deletreo, participantes.penalizacion_deletreo, participantes.nivel, participantes.instancia_alcanzada
        FROM alumnos
        JOIN participantes ON alumnos.id_alumno = participantes.id_alumno
        WHERE participantes.id_evento = $evento AND participantes.fallo = 0";

// Aplicar filtros si se proporcionan
$filters = [];
if ($nivel) {
    $filters[] = "participantes.nivel = '" . $conn->real_escape_string($nivel) . "'";
}
if ($instancia) {
    $filters[] = "participantes.instancia_alcanzada = '" . $conn->real_escape_string($instancia) . "'";
}

if (!empty($filters)) {
    $sql .= " AND " . implode(" AND ", $filters);
}

// Ordenar por tiempo de menor a mayor
$sql .= " ORDER BY CAST(participantes.tiempo_deletreo AS UNSIGNED) ASC";

$result = $conn->query($sql);

$tableRows = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tableRows .= "<tr>";
        $tableRows .= "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
        $tableRows .= "<td><input type='text' class='form-control edit-time' value='" . htmlspecialchars($row["tiempo_deletreo"]) . "' disabled data-id='" . htmlspecialchars($row["id_participante"]) . "'></td>";
        $tableRows .= "<td>" . htmlspecialchars($row["penalizacion_deletreo"]) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row["nivel"]) . "</td>";
        $tableRows .= "<td>" . htmlspecialchars($row["instancia_alcanzada"]) . "</td>";
        $tableRows .= "<td><input type='checkbox' name='select[]' value='" . htmlspecialchars($row["id_participante"]) . "'></td>";
        $tableRows .= "<td><button type='button' class='btn btn-sm btn-warning' onclick='editarTiempo(this)'>Editar</button></td>";
        $tableRows .= "<td><button type='button' class='btn btn-sm btn-success' onclick='guardarTiempo(this)' disabled>Guardar cambios</button></td>";
        $tableRows .= "</tr>";
    }
} else {
    $tableRows = "<tr><td colspan='8'>No se encontraron participantes</td></tr>";
}

if (isset($_GET['ajax'])) {
    echo $tableRows;
    exit();
}
$urlEventos = './eventos.php?id_evento=' . $evento;
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Participantes</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/verificacion.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            font-weight: 700;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table {
            border: 1px solid black;
        }
        .table thead th {
            border: 1px solid black;
        }
        .table tbody td {
            border: 1px solid black;
        }
        .bottom-container{
            width: fit-content;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="text-center">
            <h1 id="h1">Lista de Participantes</h1>
        </div>
        <form id="data-form">
            <div class="filter-container row align-items-center mb-4">
                <div class="col-auto">
                    <label for="nivel" class="fw-bold">Nivel:</label>
                    <select id="nivel" name="nivel" class="form-select w-100">
                        <option value="">Todos</option>
                        <option value="1">Nivel 1</option>
                        <option value="2">Nivel 2</option>
                        <option value="3">Nivel 3</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="instancia" class="fw-bold">Instancia:</label>
                    <select id="instancia" name="instancia" class="form-select w-100">
                        <option value="">Todas</option>
                        <option value="1">Instancia 1</option>
                        <option value="2">Instancia 2</option>
                        <option value="3">Instancia 3</option>
                    </select>
                </div>
                <div class="col ms-auto d-flex justify-content-end align-items-center">
                    <!-- <button id="volverEventos" class="btn btn-sm btn-success" onclick="window.location.href='javascript:history.back()'">Eventos</button> -->
                    <button id="filterButton" type="button" class="btn btn-primary" onclick="filterResults()">Mostrar Cambios</button>
                    <button id="botonGuardar" type="button" class="btn btn-primary" onclick="guardarSeleccion()">Guardar</button>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Tiempo</th>
                        <th>Penalizaciones</th>
                        <th>Nivel</th>
                        <th>Instancia</th>
                        <th>Seleccionar</th>
                        <th>Editar</th>
                        <th>Guardar cambios</th>
                    </tr>
                </thead>
                <tbody id="participant-table-body">
                    <?php echo $tableRows; ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterResults() {
            var nivel = document.getElementById('nivel').value;
            var instancia = document.getElementById('instancia').value;

            var tableBody = document.getElementById('participant-table-body');
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?id_evento=<?php echo $evento ?>&nivel=' + nivel + '&instancia=' + instancia + '&ajax=1', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
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
                        filterResults();
                    } else {
                        alert('Error al guardar los datos: ' + response.error);
                    }
                } else {
                    console.error("Error al guardar los datos.");
                }
            };
            xhr.send(JSON.stringify(data));
        }

        function editarTiempo(button) {
            var row = button.closest('tr');
            var timeInput = row.querySelector('.edit-time');
            var saveButton = row.querySelector('button.btn-success');

            timeInput.disabled = false;
            saveButton.disabled = false;
        }

        function guardarTiempo(button) {
            var row = button.closest('tr');
            var timeInput = row.querySelector('.edit-time');
            var id_participante = timeInput.getAttribute('data-id');
            var newTime = timeInput.value;

            var data = {
                edit: true,
                id_participante: id_participante,
                new_time: newTime
            };

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Tiempo actualizado correctamente.');
                        filterResults();
                    } else {
                        alert('Error al actualizar el tiempo: ' + response.error);
                    }
                } else {
                    console.error("Error al actualizar el tiempo.");
                }
            };
            xhr.send(JSON.stringify(data));
        }
    </script>
</body>
</html>
