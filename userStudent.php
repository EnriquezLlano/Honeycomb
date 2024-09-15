<?php
require "./conexion.php";

// Obtener el ID del alumno desde la URL
$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;

// Verificar si se recibió un ID válido
if ($id_alumno > 0) {
    $sql = "SELECT nombre, email, nivel, institucion FROM alumnos WHERE id_alumno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $stmt->bind_result($nombre, $email, $nivel, $institucion);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "ID de alumno no válido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Alumno</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Perfil del Alumno</h1>
    </header>

    <section class="perfil">
        <h2><?php echo $nombre; ?></h2>
        <p><strong>Email:</strong> <?php echo $email = (null) ? "Email no especificado" : $email ; ?></p>
        <p><strong>Nivel:</strong> <?php echo $nivel; ?></p>
        <p><strong>Institución:</strong> <?php echo $institucion; ?></p>
    </section>

    <footer>
        <p>&copy; 2024 Sistema Educativo - Perfil del Alumno</p>
    </footer>
</body>
</html>
