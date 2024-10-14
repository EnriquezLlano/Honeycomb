<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Validar que el ID del profesor esté presente en la URL
if (!isset($_GET['id_profesor']) || empty($_GET['id_profesor'])) {
    die("ID del profesor no especificado.");
}

$profesorId = intval($_GET['id_profesor']);

// Consultar datos actuales del profesor
$sqlProfesor = "SELECT * FROM profesores WHERE id_profesor = ?";
$stmtProfesor = $conn->prepare($sqlProfesor);

if (!$stmtProfesor) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmtProfesor->bind_param("i", $profesorId);
$stmtProfesor->execute();

if ($stmtProfesor->errno) {
    die("Error al ejecutar la consulta: " . $stmtProfesor->error);
}

$resultProfesor = $stmtProfesor->get_result();

// Verificar si se encontraron resultados
if ($resultProfesor->num_rows == 0) {
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
    die("Profesor no encontrado con el ID especificado.");
}

$profesor = $resultProfesor->fetch_assoc();

if (!$profesor || !isset($profesor['nombre'])) {
    die("Error al obtener los datos del profesor.");
}

// Actualizar datos del profesor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre del profesor desde el formulario
    $nombre = $_POST['nombre'];

    // Preparar la consulta de actualización
    $sqlUpdate = "UPDATE profesores SET nombre = ? WHERE id_profesor = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);

    if (!$stmtUpdate) {
        die("Error en la preparación de la actualización: " . $conn->error);
    }

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
            <a href="javascript:history.back()" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
