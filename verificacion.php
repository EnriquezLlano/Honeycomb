<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Participantes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Participantes</h1>
    <form action="guardar.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tiempo</th>
                    <th>Penalizaciones</th>
                    <th>Nivel</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                $conn = new mysqli('localhost', 'root', '', 'delectrico');

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener los datos de los alumnos y su rendimiento
                $sql = "SELECT alumnos.id as alumno_id, alumnos.nombre, alumnos.apellido, performance.id as performance_id, performance.tiempo, performance.penalizacion, alumnos.nivel
                        FROM alumnos
                        JOIN performance ON alumnos.id = performance.alumno_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Salida de datos de cada fila
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["apellido"] . "</td>";
                        echo "<td>" . $row["tiempo"] . "</td>";
                        echo "<td>" . $row["penalizacion"] . "</td>";
                        echo "<td>" . $row["nivel"] . "</td>";
                        echo "<td><input type='checkbox' name='select[]' value='" . $row["performance_id"] . "'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron participantes</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
