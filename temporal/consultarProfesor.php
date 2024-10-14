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
}

// Obtener el ID del profesor para consultar los datos
$profesorId = $_GET['id_profesor'];

// Consulta SQL para obtener los datos del profesor
$sql = "SELECT nombre FROM profesores WHERE id_profesor = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $profesorId);
$stmt->execute();
$result = $stmt->get_result();
$profesor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Profesor</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Consulta de Profesor</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nombre del Profesor: <?php echo htmlspecialchars($profesor['nombre']); ?></h5>
                <a href="inscripcionProfesor.php?id_evento=<?php echo $eventoId?>.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
