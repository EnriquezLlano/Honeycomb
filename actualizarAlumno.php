<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del alumno a actualizar
$alumnoId = $_GET['id'];

// Consultar datos actuales del alumno
$sqlAlumno = "SELECT * FROM alumnos WHERE id = ?";
$stmtAlumno = $conn->prepare($sqlAlumno);
$stmtAlumno->bind_param("i", $alumnoId);
$stmtAlumno->execute();
$resultAlumno = $stmtAlumno->get_result();
$alumno = $resultAlumno->fetch_assoc();

// Consultar opciones de profesores
$sqlProfesores = "SELECT id, nombre FROM profesores";
$resultProfesores = $conn->query($sqlProfesores);

// Consultar opciones de instituciones
$sqlInstituciones = "SELECT id, nombre FROM instituciones";
$resultInstituciones = $conn->query($sqlInstituciones);

// Consultar opciones de niveles
$sqlNiveles = "SELECT id, nivel FROM niveles";
$resultNiveles = $conn->query($sqlNiveles);

// Actualizar datos del alumno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = !empty($_POST['email']) ? $_POST['email'] : $alumno['email']; // Solo actualiza el email si se proporciona un nuevo valor
    $profesor_id = $_POST['profesor_id'];
    $institucion_id = $_POST['institucion_id'];
    $nivel_id = $_POST['nivel_id'];

    $sqlUpdate = "UPDATE alumnos SET nombre = ?, email = ?, profesor_id = ?, institucion_id = ?, nivel_id = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssiiii", $nombre, $email, $profesor_id, $institucion_id, $nivel_id, $alumnoId);
    
    if ($stmtUpdate->execute()) {
        echo "<div class='alert alert-success text-center' role='alert'>Datos actualizados correctamente</div>";
    } else {
        echo "<div class='alert alert-danger text-center' role='alert'>Error al actualizar los datos: " . $conn->error . "</div>";
    }

    $stmtUpdate->close();
}

$stmtAlumno->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Alumno</title>
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
        .form-control, .form-select {
            border-radius: 0.375rem;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Actualizar Alumno</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($alumno['email']); ?>" placeholder="Deja en blanco si no deseas cambiarlo">
            </div>
            <div class="mb-3">
                <label for="profesor_id" class="form-label">Profesor</label>
                <select class="form-select" id="profesor_id" name="profesor_id" required>
                    <?php while($rowProfesor = $resultProfesores->fetch_assoc()): ?>
                        <option value="<?php echo $rowProfesor['id']; ?>" <?php if ($rowProfesor['id'] == $alumno['profesor_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($rowProfesor['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="institucion_id" class="form-label">Institución</label>
                <select class="form-select" id="institucion_id" name="institucion_id" required>
                    <?php while($rowInstitucion = $resultInstituciones->fetch_assoc()): ?>
                        <option value="<?php echo $rowInstitucion['id']; ?>" <?php if ($rowInstitucion['id'] == $alumno['institucion_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($rowInstitucion['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nivel_id" class="form-label">Nivel</label>
                <select class="form-select" id="nivel_id" name="nivel_id" required>
                    <?php while($rowNivel = $resultNiveles->fetch_assoc()): ?>
                        <option value="<?php echo $rowNivel['id']; ?>" <?php if ($rowNivel['id'] == $alumno['nivel_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($rowNivel['nivel']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="inscripcionAlumno.php" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
