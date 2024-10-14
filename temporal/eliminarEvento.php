<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y sanitizar el ID del evento a eliminar
    $id = intval($_POST['id_evento']);

    if ($id) {
        // Preparar la consulta para eliminar el evento
        $stmt = $conn->prepare("DELETE FROM eventos WHERE id_evento = ?");
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
