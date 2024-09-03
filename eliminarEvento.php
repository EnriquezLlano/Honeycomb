<?php
require './conexion.php'; // Asegúrate de que contiene la conexión a tu base de datos.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar el ID del evento a eliminar
    $id = intval($_POST['id']);

    if ($id) {
        // Preparar la consulta para eliminar el evento
        $stmt = $conn->prepare("DELETE FROM certamenes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Evento eliminado correctamente.";
        } else {
            echo "Error al eliminar el evento: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID de evento no válido.";
    }
}

$conn->close();
?>
