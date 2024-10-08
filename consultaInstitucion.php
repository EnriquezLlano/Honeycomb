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

// Obtener el ID de la institución para consultar los datos
$institucionId = $_GET['id_institucion'];

// Consulta SQL para obtener los datos de la institución
$sql = "SELECT nombre FROM instituciones WHERE id_institucion = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $institucionId);
$stmt->execute();
$result = $stmt->get_result();
$institucion = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Institución</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            text-align: center;
        }
        .btn-secondary {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Consulta de Institución</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nombre de la Institución:</h5>
                <p class="card-text"><?php echo htmlspecialchars($institucion['nombre']); ?></p>
                <a href="inscripcionInstitucion.php?id_evento=<?php echo $eventoId?>" class="btn btn-secondary">Regresar</a>
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
