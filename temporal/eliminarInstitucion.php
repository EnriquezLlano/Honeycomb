<?php
require './conexion.php'; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id_institucion'])) {
    $id_institucion = intval($data['id_institucion']);

    $stmt = $conn->prepare("DELETE FROM instituciones WHERE id_institucion = ?");
    $stmt->bind_param("i", $id_institucion);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "institucion eliminada correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar la institucion"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de la institucion no proporcionado"]);
}

$conn->close();
?>
