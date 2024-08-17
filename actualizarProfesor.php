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

// Obtener el ID del profesor a actualizar
$profesorId = $_GET['id'];

// Consultar datos actuales del profesor
$sqlProfesor = "SELECT * FROM profesores WHERE id = ?";
$stmtProfesor = $conn->prepare($sqlProfesor);
$stmtProfesor->bind_param("i", $profesorId);
$stmtProfesor->execute();
$resultProfesor = $stmtProfesor->get_result();
$profesor = $resultProfesor->fetch_assoc();

// Actualizar datos del profesor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sqlUpdate = "UPDATE profesores SET nombre = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $nombre, $profesorId);
    
    if ($stmtUpdate->execute()) {
        echo "<div class='alert alert-success text-center' role='alert'>Datos actualizados correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>Error al actualizar los datos: " . $conn->error . "</div>";
    }

    $stmtUpdate->close();
}

$stmtProfesor->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Profesor</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Actualizar Profesor</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($profesor['nombre']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="inscripcionProfesor.php" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
