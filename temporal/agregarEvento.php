<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre_evento']);

    if (!empty($nombre)) {
        // Preparar la consulta para insertar un nuevo evento
        $stmt = $conn->prepare("INSERT INTO eventos (nombre_evento) VALUES (?)");
        $stmt->bind_param("s", $nombre);

        if ($stmt->execute()) {
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
