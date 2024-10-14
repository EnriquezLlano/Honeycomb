<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$eventoId = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;

// echo "ID del evento: " . $eventoId;

if ($eventoId == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}
// Consultar opciones de instituciones
$sqlInstituciones = "SELECT id_institucion, nombre FROM instituciones WHERE id_evento = $eventoId";
$resultInstituciones = $conn->query($sqlInstituciones);

// Insertar datos del profesor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $institucionId = $_POST['institucion_id'];

    // Cambiar $id_evento a $eventoId
    $sqlInsert = "INSERT INTO profesores (nombre, email, id_institucion) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ssi", $nombre, $email, $institucionId);

    if ($stmtInsert->execute()) {
        echo "<div class='alert alert-success text-center'>Profesor registrado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al registrar el profesor: " . $conn->error . "</div>";
    }

    $stmtInsert->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Profesor</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            text-align: center; /* Centrar todo el contenido */
        }
        .btn-custom {
            width: calc(100% - 40px); /* Ajustar el ancho en relación con el contenedor */
            height: 50px;
            font-size: 1rem;
            margin-bottom: 10px; /* Separar los botones */
        }
        .btn-custom:not(:last-child) {
            margin-bottom: 15px; /* Espacio adicional entre los botones */
        }
        .btn-custom {
            width: calc(100% - 40px); /* Ajusta el ancho de los botones */
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Registrar Profesor</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Correo Electronico</label>
                <input type="text" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="institucion_id" class="form-label">Institución</label>
                <select class="form-select" id="institucion_id" name="institucion_id" required>
                    <?php while($rowInstitucion = $resultInstituciones->fetch_assoc()): ?>
                        <option value="<?php echo $rowInstitucion['id_institucion']; ?>"><?php echo htmlspecialchars($rowInstitucion['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Registrar Profesor</button>
            <a href="inscripcionProfesor.php?id_evento=<?php echo $eventoId?>.php" class="btn btn-secondary btn-custom">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
