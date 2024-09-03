<?php
require './conexion.php'; // Asegúrate de que contiene la conexión a tu base de datos.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar y sanitizar la entrada del usuario
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        // Preparar la consulta para insertar un nuevo evento
        $stmt = $conn->prepare("INSERT INTO certamenes (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
            // Redirigir a la página de eventos con un mensaje de éxito
            header("Location: eventosRegistrados.php?mensaje=evento_agregado");
            exit();
        } else {
            echo "Error al agregar el evento: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "El nombre del evento no puede estar vacío.";
    }
}

$conn->close();
?>
