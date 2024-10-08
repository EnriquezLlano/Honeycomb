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

// Obtener el ID de la institución a actualizar
$institucionId = $_GET['id_institucion'];

// Consultar datos actuales de la institución
$sqlInstitucion = "SELECT * FROM instituciones WHERE id_institucion = ?";
$stmtInstitucion = $conn->prepare($sqlInstitucion);
$stmtInstitucion->bind_param("i", $institucionId);
$stmtInstitucion->execute();
$resultInstitucion = $stmtInstitucion->get_result();
$institucion = $resultInstitucion->fetch_assoc();

// Actualizar datos de la institución
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];

    $sqlUpdate = "UPDATE instituciones SET nombre = ? WHERE id_institucion = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $nombre, $institucionId);
    
    if ($stmtUpdate->execute()) {
        echo "<div class='alert alert-success text-center' role='alert'>Datos actualizados correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>Error al actualizar los datos: " . $conn->error . "</div>";
    }

    $stmtUpdate->close();
}

$stmtInstitucion->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Institución</title>
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
        <h1 class="text-center">Actualizar Institución</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($institucion['nombre']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="inscripcionInstitucion.php?id_evento=<?php echo $eventoId?>" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
