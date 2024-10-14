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

    echo json_encode($alumno);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumnoId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $profesor_id = $_POST['profesor_id'];
    $institucion_id = $_POST['institucion_id'];
    $nivel = $_POST['nivel'];

    $sqlUpdate = "UPDATE alumnos SET nombre = ?, id_profesor = ?, id_institucion = ?, nivel = ? WHERE id_alumno = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("siiii", $nombre, $profesor_id, $institucion_id, $nivel, $alumnoId);

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
