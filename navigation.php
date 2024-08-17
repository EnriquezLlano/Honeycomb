<?php
session_start();

require './conexion.php';

// Inicializar current_index si no está configurado
if (!isset($_SESSION['current_index'])) {
    $_SESSION['current_index'] = 0;
}

// Obtener el número total de registros
$result = $conn->query("SELECT COUNT(*) AS total FROM performance WHERE descalificados = 0");
$row = $result->fetch_assoc();
$totalRecords = $row['total'];

// Manejo de la navegación
if (isset($_GET['action'])) {
    echo "Acción detectada: " . $_GET['action'] . "<br>";

    if ($_GET['action'] == 'prev') {
        echo "Acción: prev<br>";
        if ($_SESSION['current_index'] > 0) {
            $_SESSION['current_index']--;
            echo "Índice actual decrementado: " . $_SESSION['current_index'] . "<br>";
        }
    } else if ($_GET['action'] == 'next') {
        echo "Acción: next<br>";
        if ($_SESSION['current_index'] < $totalRecords - 1) {
            $_SESSION['current_index']++;
            echo "Índice actual incrementado: " . $_SESSION['current_index'] . "<br>";
        }
    } 
}


$conn->close();

header('Location: eventos.php');
exit;
?>
