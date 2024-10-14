<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception(".env file not found");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Remover comillas
        $value = trim($value, "\"'");

        $_ENV[$name] = $value;
    }
}

try {
    // Cargar el archivo .env
    loadEnv(__DIR__ . '/.env');

    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_errno) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // Éxito
    echo "Conexión exitosa";
} catch (Exception $e) {
    // Manejo de errores
    error_log($e->getMessage(), 3, __DIR__ . '/error_log.txt');
    echo $e->getMessage(), 3, __DIR__ . '/error_log.txt';
    die("Error de conexión. Por favor, verifica los registros para más detalles.");
}
?>