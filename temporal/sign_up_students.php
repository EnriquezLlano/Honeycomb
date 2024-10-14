<?php
require './conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./styles/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/sign_up.css">
    <title>Sign Up</title>
</head>

<body>
    <section class="form-container" id="form-container">
        <h1>Honeycomb</h1>
        <form class="form" method="POST" action="registro.php">
            <label class="label" for="nombre">Nombre:</label>
            <input class="input input-username" type="text" name="username" placeholder="Nombre de usuario" required>
            <label class="label" for="email">Correo electrónico:</label>
            <input class="input input-email" type="email" name="email" placeholder="correo@gmail.com" required>
            <label class="label" for="current-password">Password</label>
            <input class="input input-password" type="current-password" name="password" placeholder="C@ntraseña020824" required>
            <button class="register-button" type="submit">Sign Up</button>
            <a class="login-button" href="./login.php">¿Ya tiene cuenta?</a>
        </form>
    </section>
    <!-- <section class="form-container-"></section> -->
    <section class="section-rafiki-desk">
        <img class="rafiki-svg rafiki-desk" src="./styles/images/Sign-up-desk.svg" alt="">
    </section>
    <section class="section-rafiki-mobile">
        <img class="rafiki-svg rafiki-mobile" src="./styles/images/Sign-up-mobile-option-2.svg" alt="">
    </section>
    <!-- <section class="atributte">
        <a href="https://storyset.com/people">People illustrations by Storyset</a>
    </section> -->
</body>

</html>