<?php
require "./conexion.php";

// Obtener el ID del profesor desde la URL
$id_profesor = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar si se recibió un ID válido
if ($id_profesor > 0) {
    // Consulta SQL para obtener los datos del profesor
    $sql = "SELECT nombre, apellido, email, institucion FROM profesores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_profesor);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $email, $institucion);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "ID de profesor no válido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Profesor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Perfil del Profesor</h1>
    </header>

    <section class="perfil">
        <h2><?php echo $nombre . " " . $apellido; ?></h2>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Institución:</strong> <?php echo $institucion; ?></p>
    </section>

    <footer>
        <p>&copy; 2024 Sistema Educativo - Perfil del Profesor</p>
    </footer>
</body>
</html>
