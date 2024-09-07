<?php
require './conexion.php'; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si el ID del alumno está presente
if (isset($data['id'])) {
    $idAlumno = intval($data['id']);

    // Preparar y ejecutar la consulta para eliminar el alumno de la tabla 'performance'
    $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
    $stmt->bind_param("i", $idAlumno);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Alumno eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el alumno"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de alumno no proporcionado"]);
}

$conn->close();
?>
