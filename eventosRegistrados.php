<?php
require './conexion.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar nombres de certámenes
$sql = "SELECT nombre FROM certamenes ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        .eventos-container {
            border: 2px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-evento {
            width: 500px;
            font-size: 18px;
            margin: 10px auto;
            display: block;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>Eventos</h1>
        <div class="eventos-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <button class="btn btn-primary btn-evento">
                        <?php echo htmlspecialchars($row['nombre']); ?>
                    </button>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay eventos registrados.</p>
            <?php endif; ?>
        </div>
        <div class="btn-container">
            <button class="btn btn-success">Agregar Evento</button>
            <button class="btn btn-danger">Eliminar Evento</button>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
