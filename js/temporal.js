// Obtener el número total de registros
$result = $conn->query("SELECT COUNT(*) AS total FROM performance");
$row = $result->fetch_assoc();
$totalRecords = $row['total'];

// Obtener los parámetros del nivel y la instancia
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : null;
$instanciaActual = isset($_GET['instancia']) ? $_GET['instancia'] : null;

$instanciaSiguiente = $instanciaActual + 1;

$stmt = $conn->prepare("SELECT cantidad_participantes FROM instancias WHERE id = ?");
$stmt->bind_param("i", $instanciaSiguiente);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$limiteAvance = $row['cantidad_participantes'];
$stmt->close();

function avanzarParticipantes($conn, $nivel, $instanciaActual, $instanciaSiguiente, $limiteAvance) {
    echo "La función avanzarParticipantes ha sido llamada.<br>";
    // Selecciona los mejores tiempos de la instancia actual
    $querySeleccionar = "
        SELECT alumno_id, tiempo 
        FROM performance 
        WHERE instancia = ? AND nivel = ? 
        ORDER BY tiempo ASC 
        LIMIT ?";

    $stmtSeleccionar = $conn->prepare($querySeleccionar);
    if (!$stmtSeleccionar) {
        die("Error en la preparación de la consulta seleccionar: " . $conn->error);
    }

    if (!$stmtSeleccionar->bind_param("iii", $instanciaActual, $nivel, $limiteAvance)) {
        die("Error en la vinculación de parámetros para la consulta seleccionar: " . $stmtSeleccionar->error);
    }

    if (!$stmtSeleccionar->execute()) {
        die("Error en la ejecución de la consulta seleccionar: " . $stmtSeleccionar->error);
    }

    $resultadoAvances = $stmtSeleccionar->get_result();
    if (!$resultadoAvances) {
        die("Error al obtener el resultado de la consulta seleccionar: " . $stmtSeleccionar->error);
    }

    // Inserta los participantes seleccionados en la siguiente instancia
    $queryInsertar = "
        INSERT INTO performance (alumno_id, instancia, nivel) 
        VALUES (?, ?, ?)";

    $stmtInsertar = $conn->prepare($queryInsertar);
    if (!$stmtInsertar) {
        die("Error en la preparación de la consulta insertar: " . $conn->error);
    }

    while ($row = $resultadoAvances->fetch_assoc()) {
        $alumnoId = $row['alumno_id'];
        
        if (!$stmtInsertar->bind_param("iii", $alumnoId, $instanciaSiguiente, $nivel)) {
            die("Error en la vinculación de parámetros para la consulta insertar: " . $stmtInsertar->error);
        }

        if (!$stmtInsertar->execute()) {
            die("Error en la ejecución de la consulta insertar: " . $stmtInsertar->error);
        }
    }

    // Libera los recursos
    $stmtSeleccionar->close();
    $stmtInsertar->close();
}