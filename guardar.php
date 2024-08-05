<?php
require './conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Conexión fallida: ' . $conn->connect_error]);
    exit();
}

// Verificar si se han enviado datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['performance_id']) && isset($data['tiempo']) && isset($data['penalizaciones'])) {
        $performance_id = $data['performance_id'];
        $tiempo = $data['tiempo'];
        $penalizaciones = $data['penalizaciones'];

        // Preparar la consulta para actualizar los datos del participante
        $sql_update = "UPDATE performance SET tiempo = ?, penalizacion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . $conn->error]);
            exit();
        }

        $stmt->bind_param('ssi', $tiempo, $penalizaciones, $performance_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar datos: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Datos JSON no válidos o faltantes.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no permitido.']);
}

$conn->close();
?>
