<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception(".env file not found");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        $value = trim($value, "\"'");

        $_ENV[$name] = $value;
    }
}

// Cargar el archivo .env
loadEnv(__DIR__ . '/.env');

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variable de búsqueda
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

// Consulta SQL con INNER JOIN para obtener los datos
$sql = "SELECT alumnos.id AS id_alumno, alumnos.nombre AS nombre_alumno, profesores.nombre AS nombre_profesor, instituciones.nombre AS nombre_institucion 
        FROM alumnos 
        INNER JOIN profesores ON alumnos.profesor_id = profesores.id 
        INNER JOIN instituciones ON alumnos.institucion_id = instituciones.id";

if (!empty($search)) {
    $sql .= " WHERE alumnos.nombre LIKE ?";
}

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("s", $searchTerm);
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
            <a href="registroInstitucion.php" class="btn btn-primary ms-3">Registrar Institucion</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre de la Institución</th>
                    <th>Nombre del Alumno</th>
                    <th>Nombre del Profesor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_institucion']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_alumno']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                            <td>
                                <a href="consultaInstitucion.php?id=<?php echo $row['id_alumno']; ?>" class="btn btn-primary btn-sm">Consultar</a>
                                <a href="actualizarInstitucion.php?id=<?php echo $row['id_alumno']; ?>" class="btn btn-warning btn-sm">Actualizar</a>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
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

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
