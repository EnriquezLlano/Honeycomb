<?php
require './conexion.php';

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibieron los datos por POST
if (isset($_POST['id_participante']) && isset($_POST['fallo'])) {
    $id_participante = intval($_POST['id_participante']);
    $fallo = intval($_POST['fallo']);  // 1 indica que el participante está descalificado

    // Depuración: Muestra los valores que se están recibiendo
    var_dump($id_participante, $fallo);

    $sql = "UPDATE participantes SET fallo = ? WHERE id_participante = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $fallo, $id_participante);

    if ($stmt->execute()) {
        echo "El participante ha sido descalificado exitosamente.";
    } else {
        echo "Error al descalificar al participante: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Datos incompletos.";
}


$conn->close();
?>
