<?php
session_start();

include 'conexion.php';

// Inicializar current_index si no está configurado
if (!isset($_SESSION['current_index'])) {
    $_SESSION['current_index'] = 0;
}

// Obtener el número total de registros
$result = $conn->query("SELECT COUNT(*) AS total FROM performance");
$row = $result->fetch_assoc();
$totalRecords = $row['total'];
$conn->close();

// Manejo de la navegación
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'prev') {
        if ($_SESSION['current_index'] > 0) {
            $_SESSION['current_index']--;
        }
    } else if ($_GET['action'] == 'next') {
        if ($_SESSION['current_index'] < $totalRecords - 1) {
            $_SESSION['current_index']++;
        }
    }
}

header('Location: index.php');
exit;
?>
