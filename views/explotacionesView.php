<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("Location: ../index.html");
    exit();
}

$usuarioID = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuaderno Agrícola - Explotaciones">
    <title>Cuaderno Agrícola - Explotaciones</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Cuaderno Agrícola</h1>
        <p>Bienvenido, <?php echo $usuarioID; ?>!</p>
    </header>
    <main>
        <h2>Explotaciones</h2>
        <p>Esta es la vista de las explotaciones.</p>
    </main>
</body>
</html>