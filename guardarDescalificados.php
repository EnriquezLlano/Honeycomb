<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    descalificarParticipante($id);
}

function descalificarParticipante($alumno_id) {
    global $conn; // Usa la conexión global a la base de datos

    $sql = "UPDATE performance SET descalificado = TRUE WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $alumno_id);

    if ($stmt->execute()) {
        echo "Participante descalificado exitosamente.";
    } else {
        echo "Error al descalificar al participante: " . $conn->error;
    }

    $stmt->close();
}
?>
