<?php 
$eventoId = isset($_GET['id_evento']) ? intval($_GET['id_evento']) : 0;

if ($eventoId == 0) {
    echo "No se ha seleccionado un evento válido.";
    exit;
}?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
        }
        h1 {
            margin-bottom: 30px;
        }
        .btn-group {
            border: 2px solid #000; /* Borde alrededor de todos los botones */
            border-radius: 5px;
            padding: 20px; /* Espaciado interno del contenedor del marco */
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .btn-custom, .btn-start {
            width: 350px; /* Ajustar el tamaño del botón */
            height: 60px; /* Ajustado proporcionalmente */
            font-size: 1.5rem; /* Tamaño de fuente más grande */
            margin: 10px 0; /* Espaciado entre botones */
            text-align: center;
            line-height: 60px; /* Centrado vertical del texto */
            text-decoration: none; /* Quitar subrayado de los enlaces */
            border: none; /* Eliminar borde */
            border-radius: 5px; /* Bordes redondeados */
        }
        .btn-start {
            background-color: #28a745;
            color: white;
        }
        .btn-start:hover {
            background-color: #218838;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1>Menú</h1>
        <div class="btn-group">
            <a href="index.php" class="btn btn-start">Inicio</a>
            <a href="inscripcionAlumno.php?id_evento=<?php echo $eventoId ?>" class="btn btn-custom">Registrar Alumno</a>
            <a href="inscripcionProfesor.php?id_evento=<?php echo $eventoId ?>" class="btn btn-custom">Registrar Profesor</a>
            <a href="inscripcionInstitucion.php?id_evento=<?php echo $eventoId ?>" class="btn btn-custom">Registrar Institución</a>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
