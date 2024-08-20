<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar opciones de profesores
$sqlProfesores = "SELECT id, nombre FROM profesores";
$resultProfesores = $conn->query($sqlProfesores);

// Consultar opciones de instituciones
$sqlInstituciones = "SELECT id, nombre FROM instituciones";
$resultInstituciones = $conn->query($sqlInstituciones);

// Consultar opciones de niveles
$sqlNiveles = "SELECT id, nivel FROM niveles";
$resultNiveles = $conn->query($sqlNiveles);

// Registrar nuevo alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $profesor_id = $_POST['profesor_id'];
    $institucion_id = $_POST['institucion_id'];
    $nivel_id = $_POST['nivel_id'];

    $sqlInsert = "INSERT INTO alumnos (nombre, email, profesor_id, institucion_id, nivel_id) VALUES (?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ssiii", $nombre, $email, $profesor_id, $institucion_id, $nivel_id);
    
    if ($stmtInsert->execute()) {
        echo "<div class='alert alert-success text-center'>Alumno registrado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al registrar el alumno: " . $conn->error . "</div>";
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
    <title>Registrar Alumno</title>
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
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centrar todo el contenido */
        }
        .btn-custom {
            width: 100%; /* Ajustar el ancho al contenedor */
            height: 50px;
            font-size: 1rem;
            margin-bottom: 10px; /* Separar los botones */
        }
        .btn-custom:not(:last-child) {
            margin-bottom: 15px; /* Espacio adicional entre los botones */
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Registrar Alumno</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="profesor_id" class="form-label">Profesor</label>
                <select class="form-select" id="profesor_id" name="profesor_id" required>
                    <?php while($rowProfesor = $resultProfesores->fetch_assoc()): ?>
                        <option value="<?php echo $rowProfesor['id']; ?>"><?php echo htmlspecialchars($rowProfesor['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="institucion_id" class="form-label">Institución</label>
                <select class="form-select" id="institucion_id" name="institucion_id" required>
                    <?php while($rowInstitucion = $resultInstituciones->fetch_assoc()): ?>
                        <option value="<?php echo $rowInstitucion['id']; ?>"><?php echo htmlspecialchars($rowInstitucion['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nivel_id" class="form-label">Nivel</label>
                <select class="form-select" id="nivel_id" name="nivel_id" required>
                    <?php while($rowNivel = $resultNiveles->fetch_assoc()): ?>
                        <option value="<?php echo $rowNivel['id']; ?>"><?php echo htmlspecialchars($rowNivel['nivel']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Registrar Alumno</button>
            <a href="inscripcionAlumno.php" class="btn btn-secondary btn-custom">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
