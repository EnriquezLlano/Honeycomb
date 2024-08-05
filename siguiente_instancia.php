<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Siguiente Instancia</title>
</head>
<body>
    <h1>Siguiente Instancia - Tiempos Ascendentes</h1>

    <?php
    // Configuración de conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "delectrico";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar si se han enviado datos por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select'])) {
        // Array de IDs seleccionados
        $selected_ids = $_POST['select'];

        // Verificar si hay elementos seleccionados
        if (!empty($selected_ids)) {
            // Preparar la consulta para insertar los datos seleccionados en la tabla performance
            $sql_insert = "INSERT INTO performance (alumno_id, tiempo, penalizacion, instancia_id) VALUES ";

            // Iterar sobre los IDs seleccionados
            foreach ($selected_ids as $performance_id) {
                // Obtener los datos del rendimiento del alumno según el ID de performance
                $sql_data = "SELECT alumno_id, '00:00' as tiempo, 0 as penalizacion, 2 as instancia_id FROM performance WHERE id = $performance_id";
                $result_data = $conn->query($sql_data);

                if ($result_data->num_rows > 0) {
                    $row = $result_data->fetch_assoc();
                    $alumno_id = $row['alumno_id'];
                    $tiempo = $row['tiempo'];
                    $penalizacion = $row['penalizacion'];
                    $instancia_id = $row['instancia_id'];

                    // Agregar los valores a la consulta de inserción
                    $sql_insert .= "('$alumno_id', '$tiempo', '$penalizacion', '$instancia_id'), ";
                }
            }

            // Eliminar la última coma y espacio en blanco de la consulta de inserción
            $sql_insert = rtrim($sql_insert, ', ');

            // Ejecutar la consulta de inserción
            if ($conn->query($sql_insert) === TRUE) {
                echo "<p>Datos guardados correctamente en la tabla performance.</p>";
            } else {
                echo "Error al insertar datos: " . $conn->error;
            }
        } else {
            echo "No se han seleccionado participantes para guardar.";
        }
    } else {
        echo "No se han enviado datos por POST.";
    }

    $conn->close();
    ?>

    <br>
    <form method="post" action="siguiente_instancia.php">
        <button type="submit" name="reiniciar">Reiniciar Datos Guardados</button>
    </form>
</body>
</html>
