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

$sql = "SELECT instituciones.id_institucion AS id_institucion, 
               instituciones.nombre AS nombre_institucion, 
               GROUP_CONCAT(DISTINCT profesores.nombre SEPARATOR ', ') AS nombre_profesores, 
               GROUP_CONCAT(DISTINCT alumnos.nombre SEPARATOR ', ') AS nombre_alumnos
        FROM instituciones
        LEFT JOIN profesores ON profesores.id_institucion = instituciones.id_institucion
        LEFT JOIN alumnos ON alumnos.id_institucion = instituciones.id_institucion
        WHERE instituciones.id_evento = ?";
if (!empty($search)) {
    $sql .= " AND instituciones.nombre LIKE ?";
}

$sql .= " GROUP BY instituciones.id_institucion";
$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("is", $eventoId, $searchTerm);
} else {
    $stmt->bind_param("i", $eventoId);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instituciones</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
        .bottom-container { width: fit-content; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="text-center">
            <h1>Instituciones</h1>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <form method="POST" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Buscar institucion" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-custom" type="submit">Buscar</button>
                </div>
            </form>
            <a href="registroInstitucion.php?id_evento=<?php echo $eventoId ?>" class="btn btn-primary ms-3">Registrar Institucion</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre de la Institución</th>
                    <th>Nombres de los Alumnos</th>
                    <th>Nombres de los Profesores</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_institucion']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_alumnos']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_profesores']); ?></td>
                            <td>
                                <a href="consultaInstitucion.php?id_evento=<?php echo $eventoId?>&id_institucion=<?php echo $row['id_institucion']; ?>" class="btn btn-primary btn-sm">Consultar</a>
                                <a href="actualizarInstitucion.php?id_evento=<?php echo $eventoId?>&id_institucion=<?php echo $row['id_institucion']; ?>" class="btn btn-warning btn-sm">Actualizar</a>
                                <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $row['id_institucion']; ?>)">Eliminar</button>
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
    </div>
    <div class="bottom-container">
        <!-- <a href="./inscripcionAlumno.php?id_evento=<?php echo $eventoId ?>" class="btn-bottom btn btn-primary ms-3">Alumnos</a> -->
        <a href="./inscripcionProfesor.php?id_evento=<?php echo $eventoId ?>" class="btn-bottom btn btn-primary ms-3">Profesores</a>
        <a href="./eventosRegistrados.php" class="btn-bottom btn btn-primary ms-3">Eventos Registrados</a>
        <!-- <a href="./eventos?id_evento=<?php echo $eventoId?>.php" class="btn-bottom btn btn-primary ms-3">Ir al cronómetro</a> -->
    </div>
    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmarEliminacion(id_institucion) {
            if (confirm('¿Estás seguro de que deseas eliminar esta institucion?')) {
                fetch('eliminarInstitucion.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id_institucion: id_institucion })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
