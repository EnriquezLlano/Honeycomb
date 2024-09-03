<?php
require './conexion.php';

// Consultar nombres de certámenes
$sql = "SELECT id, nombre FROM certamenes ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fuente Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        .eventos-container {
            border: 2px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn-evento {
            width: 500px;
            font-size: 18px;
            margin: 10px auto;
            display: block;
            cursor: pointer;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .btn-evento.selected {
            background-color: #15355A;
            border-color: #15355A;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1>Eventos</h1>
        <div class="eventos-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <button id="evento-<?php echo $row['id']; ?>" data-id="<?php echo $row['id']; ?>" class="btn btn-primary btn-evento">
                        <?php echo htmlspecialchars($row['nombre']); ?>
                    </button>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay eventos registrados.</p>
            <?php endif; ?>
        </div>
        <div class="btn-container">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarEventoModal">Agregar Evento</button>
            <button id="btnEliminar" class="btn btn-danger" disabled>Eliminar Evento</button>
            <button id="btnInscripcion" class="btn btn-primary" disabled>Ir a Inscripción</button>
        </div>
    </div>

    <!-- Modal para Agregar Evento -->
    <div class="modal fade" id="agregarEventoModal" tabindex="-1" aria-labelledby="agregarEventoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarEventoModalLabel">Agregar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAgregarEvento" action="agregarEvento.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombreEvento" class="form-label">Nombre del Evento</label>
                            <input type="text" class="form-control" id="nombreEvento" name="nombre" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedEventId = null;

        // Manejo de selección de eventos
        document.querySelectorAll('.btn-evento').forEach(button => {
            button.addEventListener('click', () => {
                // Deseleccionar todos los botones
                document.querySelectorAll('.btn-evento').forEach(btn => btn.classList.remove('selected'));

                // Seleccionar el botón actual
                button.classList.add('selected');
                
                // Guardar el ID del evento seleccionado
                selectedEventId = button.getAttribute('data-id');

                // Habilitar botones de eliminar y inscripción
                document.getElementById('btnEliminar').disabled = false;
                document.getElementById('btnInscripcion').disabled = false;
            });

            // Doble clic para ir a la inscripción
            button.addEventListener('dblclick', () => {
                if (selectedEventId) {
                    // Guardar el ID en localStorage y redirigir
                    localStorage.setItem('selectedEventId', selectedEventId);
                    window.location.href = 'inscripcionAlumno.php';
                }
            });
        });

        // Manejo de eliminación de eventos
        document.getElementById('btnEliminar').addEventListener('click', () => {
            if (selectedEventId) {
                // Confirmar eliminación
                if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                    // Enviar solicitud para eliminar el evento
                    fetch('eliminarEvento.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${selectedEventId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        alert('Evento eliminado exitosamente.');
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error al eliminar el evento:', error);
                        alert('Hubo un error al intentar eliminar el evento.');
                    });
                }
            } else {
                alert('Por favor, selecciona un evento para eliminar.');
            }
        });

        // Manejo del botón de inscripción
        document.getElementById('btnInscripcion').addEventListener('click', () => {
            if (selectedEventId) {
                // Guardar el ID en localStorage y redirigir
                localStorage.setItem('selectedEventId', selectedEventId);
                window.location.href = 'inscripcionAlumno.php';
            } else {
                alert('Por favor, selecciona un evento para inscribir.');
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
