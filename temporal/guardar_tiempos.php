<?php
require 'conexion.php';
$data = json_decode(file_get_contents('php://input'), true);

$id_participante = $data['id_participante'];
$tiempo_deletreo = $data['tiempo_deletreo'];
$tiempo_oracion = $data['tiempo_oracion'];
$tiempo_total = $data['tiempo_total'];
$penalizacion_deletreo = $data['penalizacion_deletreo'];
$penalizacion_oracion = $data['penalizacion_oracion'];

$sql = "UPDATE participantes SET 
        tiempo_deletreo = '$tiempo_deletreo', 
        tiempo_oracion = '$tiempo_oracion',
        tiempo_total = '$tiempo_total',
        penalizacion_deletreo = '$penalizacion_deletreo', 
        penalizacion_oracion = '$penalizacion_oracion' 
        WHERE id_participante = $id_participante";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
