<?php
require './conexion.php';

// Inicializar variables
$search = "";
$certamenId = "";

// Recuperar valores enviados por GET en lugar de POST
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['certamen_id'])) {
    $certamenId = $_GET['certamen_id'];
}

// Verificar si el ID del certamen está presente
if (empty($certamenId)) {
    die("Certamen no especificado.");
}

// Consulta SQL con INNER JOIN para obtener los datos y filtrar por certamen
$sql = "SELECT profesores.id AS id_profesor, 
               profesores.nombre AS nombre_profesor, 
               instituciones.nombre AS nombre_institucion 
        FROM profesores 
        INNER JOIN alumnos ON alumnos.profesor_id = profesores.id
        INNER JOIN instituciones ON alumnos.institucion_id = instituciones.id
        INNER JOIN certamenes ON alumnos.certamen_id = certamenes.id
        WHERE certamenes.id = ?";

if (!empty($search)) {
    $sql .= " AND profesores.nombre LIKE ?";
}

$stmt = $conn->prepare($sql);

// Configurar los parámetros de la consulta
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("is", $certamenId, $searchTerm);
} else {
    $stmt->bind_param("i", $certamenId);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
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
            <h1>Profesores</h1>
        </div>
        <div class="d-flex justify-content-center mb-4">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Buscar profesor" value="<?php echo htmlspecialchars($search); ?>">
                    <input type="hidden" name="certamen_id" value="<?php echo htmlspecialchars($certamenId); ?>">
                    <button class="btn btn-custom" type="submit">Buscar</button>
                </div>
            </form>
            <a href="registroProfesor.php" class="btn btn-primary ms-3">Registrar Profesor</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Profesor</th>
                    <th>Nombre de la Institución</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre_profesor']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre_institucion']); ?></td>
                            <td>
                                <a href="consultarProfesor.php?id=<?php echo htmlspecialchars($row['id_profesor']); ?>" class="btn btn-primary btn-sm">Consultar</a>
                                <a href="actualizarProfesor.php?id=<?php echo htmlspecialchars($row['id_profesor']); ?>" class="btn btn-warning btn-sm">Actualizar</a>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron registros</td>
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
