<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_participante'];
    descalificarParticipante($id);
}

function descalificarParticipante($id) {
    global $conn;

    $sql = "UPDATE participantes SET fallo = NOT fallo WHERE id_participante = ?";
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
