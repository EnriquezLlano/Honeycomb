<?php
require './conexion.php'; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$eventoId = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;

if ($eventoId == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
} 

// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Ajuste de la consulta SQL
$sql = "SELECT participantes.id_participante AS id_participante, 
               participantes.id_alumno AS id_alumno, 
               participantes.id_evento AS id_evento, 
               participantes.nivel AS nivel, 
               participantes.instancia_alcanzada,
               alumnos.id_profesor, 
               alumnos.id_institucion, 
               participantes.instancia_alcanzada,
               alumnos.nombre AS nombre_alumno, 
               profesores.nombre AS nombre_profesor, 
               instituciones.nombre AS nombre_institucion
        FROM participantes
        INNER JOIN alumnos ON participantes.id_alumno = alumnos.id_alumno
        INNER JOIN profesores ON alumnos.id_profesor = profesores.id_profesor
        INNER JOIN instituciones ON alumnos.id_institucion = instituciones.id_institucion
        INNER JOIN eventos ON participantes.id_evento = eventos.id_evento
        WHERE eventos.id_evento = ? AND participantes.instancia_alcanzada = 1";

if (!empty($search)) {
    $sql .= " AND alumnos.nombre LIKE ?";
}

$stmt = $conn->prepare($sql);

// Verificar y vincular los parámetros según si hay búsqueda
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("is", $eventoId, $searchTerm);
} else {
    $stmt->bind_param("i", $eventoId);
}

$stmt->execute();
$result = $stmt->get_result();

// Consultar opciones de profesores
$sqlProfesores = "SELECT id_profesor, nombre FROM profesores";
$resultProfesores = $conn->query($sqlProfesores);

// Consultar opciones de instituciones
$sqlInstituciones = "SELECT id_institucion, nombre FROM instituciones";
$resultInstituciones = $conn->query($sqlInstituciones);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <!-- Bootstrap y estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        h1 { font-weight: 700; }
        .btn{ max-height: 40px;}
        .btn-custom { background-color: #007bff; color: white; border: none; }
        .btn-custom:hover { background-color: #0056b3; }
        .table th, .table td { text-align: center; vertical-align: middle; }
        .table { border: 1px solid black; }
        .table thead th { border: 1px solid black; }
        .table tbody td { border: 1px solid black; }
        .bottom-container { width: fit-content; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="text-center">
            <h1>Alumnos Inscritos</h1>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Buscar alumno" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-custom" type="submit">Buscar</button>
                </div>
            </form>
            <a href="registroAlumno.php?id_evento=<?php echo $eventoId?>" class="btn btn-primary ms-3" onclick="redireccionar()">Registrar Alumno</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Alumno</th>
                    <th>Nombre del Profesor</th>
                    <th>Nombre de la Institución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_alumno']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_institucion']); ?></td>
                            <td>
                                <a href="consultaAlumno.php?id_alumno=<?php echo $row['id_alumno']; ?>" class="btn btn-primary btn-sm">Consultar</a>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal" 
                                        data-id="<?php echo $row['id_alumno']; ?>"
                                        data-nombre="<?php echo htmlspecialchars($row['nombre_alumno']); ?>"
                                        data-profesor="<?php echo $row['id_profesor']; ?>"
                                        data-institucion="<?php echo $row['id_institucion']; ?>"
                                        data-nivel="<?php echo $row['nivel']; ?>">Actualizar</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $row['id_alumno']; ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron registros</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="bottom-container">
            <a href="./eventosRegistrados.php" class="btn-bottom btn btn-primary ms-3">Eventos Registrados</a>
            <a href="./inscripcionInstitucion.php?id_evento=<?php echo $eventoId ?>" class="btn-bottom btn btn-primary ms-3">Instituciones</a>
            <a href="./inscripcionProfesor.php?id_evento=<?php echo $eventoId ?>" class="btn-bottom btn btn-primary ms-3">Profesores</a>
            <a href="./eventos.php?id_evento=<?php echo $eventoId ?>" class="btn-bottom btn btn-primary ms-3">Ir al cronómetro</a>
        </div>
    </div>

    <!-- Modal para actualizar datos del alumno -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Actualizar Alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modalAlumnoId">
                        <div class="mb-3">
                            <label for="modalNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="modalNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalProfesor" class="form-label">Profesor</label>
                            <select class="form-select" id="modalProfesor" name="profesor_id" required>
                                <?php while($rowProfesor = $resultProfesores->fetch_assoc()): ?>
                                    <option value="<?php echo $rowProfesor['id_profesor']; ?>"><?php echo htmlspecialchars($rowProfesor['nombre']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalInstitucion" class="form-label">Institución</label>
                            <select class="form-select" id="modalInstitucion" name="institucion_id" required>
                                <?php while($rowInstitucion = $resultInstituciones->fetch_assoc()): ?>
                                    <option value="<?php echo $rowInstitucion['id_institucion']; ?>"><?php echo htmlspecialchars($rowInstitucion['nombre']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalNivel" class="form-label">Nivel</label>
                            <input type="number" class="form-control" id="modalNivel" name="nivel" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    var updateModal = document.getElementById('updateModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botón que disparó el modal
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        var profesor = button.getAttribute('data-profesor');
        var institucion = button.getAttribute('data-institucion');
        var nivel = button.getAttribute('data-nivel');

        document.getElementById('modalAlumnoId').value = id;
        document.getElementById('modalNombre').value = nombre;
        document.getElementById('modalProfesor').value = profesor;
        document.getElementById('modalInstitucion').value = institucion;
        document.getElementById('modalNivel').value = nivel;
    });


    function confirmarEliminacion(id_alumno) {
        if (confirm('¿Estás seguro de que deseas eliminar a este alumno?')) {
            fetch('eliminarAlumno.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_alumno: id_alumno })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Recargar la página para reflejar los cambios
                } else {
                    alert('Error al eliminar: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    // Manejar el envío del formulario con AJAX
    document.getElementById('updateForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch('actualizarAlumno.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                //alert(data.message);
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>
</html>

<?php 
$stmt->close();
$conn->close();
?>
