<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    descalificarParticipante($id);
}

function descalificarParticipante($id) {
    global $conn; // Usa la conexión global a la base de datos

    $sql = "UPDATE performance SET descalificados = TRUE WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Participante descalificado exitosamente.";
    } else {
        echo "Error al descalificar al participante: " . $conn->error;
    }

    $stmt->close();
}
?>
