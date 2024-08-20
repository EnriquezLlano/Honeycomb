<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del alumno para consultar los datos
$alumnoId = $_GET['id'];

// Consulta SQL con INNER JOIN para obtener los datos
$sql = "SELECT alumnos.nombre AS nombre_alumno, alumnos.email, profesores.nombre AS nombre_profesor, instituciones.nombre AS nombre_institucion, niveles.nivel AS nombre_nivel 
        FROM alumnos 
        INNER JOIN profesores ON alumnos.profesor_id = profesores.id 
        INNER JOIN instituciones ON alumnos.institucion_id = instituciones.id 
        INNER JOIN niveles ON alumnos.nivel_id = niveles.id 
        WHERE alumnos.id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $alumnoId);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Alumno</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-secondary {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Consulta de Alumno</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nombre del Alumno: <?php echo htmlspecialchars($alumno['nombre_alumno']); ?></h5>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($alumno['email']); ?></p>
                <p class="card-text"><strong>Profesor:</strong> <?php echo htmlspecialchars($alumno['nombre_profesor']); ?></p>
                <p class="card-text"><strong>Institución:</strong> <?php echo htmlspecialchars($alumno['nombre_institucion']); ?></p>
                <p class="card-text"><strong>Nivel:</strong> <?php echo htmlspecialchars($alumno['nombre_nivel']); ?></p>
                <a href="inscripcionAlumno.php" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
