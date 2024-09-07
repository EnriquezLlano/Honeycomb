<?php
require './conexion.php'; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $alumnoId = $_GET['id'];

    $sqlAlumno = "SELECT * FROM alumnos WHERE id = ?";
    $stmtAlumno = $conn->prepare($sqlAlumno);
    $stmtAlumno->bind_param("i", $alumnoId);
    $stmtAlumno->execute();
    $resultAlumno = $stmtAlumno->get_result();
    $alumno = $resultAlumno->fetch_assoc();

    echo json_encode($alumno); // Retorna los datos en formato JSON
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumnoId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $profesor_id = $_POST['profesor_id'];
    $institucion_id = $_POST['institucion_id'];
    $nivel_id = $_POST['nivel_id'];

    $sqlUpdate = "UPDATE alumnos SET nombre = ?, email = ?, profesor_id = ?, institucion_id = ?, nivel_id = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssiiii", $nombre, $email, $profesor_id, $institucion_id, $nivel_id, $alumnoId);

    if ($stmtUpdate->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Alumno actualizado correctamente.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
    }

    $stmtUpdate->close();
    $conn->close();
    exit;
}
?>
