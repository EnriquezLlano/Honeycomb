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

    if (json_last_error() === JSON_ERROR_NONE && isset($data['id_participante']) && isset($data['tiempo_oracion']) && isset($data['penalizacion_oracion'])) {
        $id_participante = $data['id_participante'];
        $tiempo_oracion = $data['tiempo_oracion'];
        $penalizacion_oracion = $data['penalizacion_oracion'];

        // Preparar la consulta para actualizar los datos del participante
        $sql_update = "UPDATE performance SET tiempo_oracion = ?, penalizacion_oracion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . $conn->error]);
            exit();
        }

        // Cambiar el tipo de parámetro para coincidir con los datos
        $stmt->bind_param('sii', $tiempo_oracion, $penalizacion_oracion, $id_participante);
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
