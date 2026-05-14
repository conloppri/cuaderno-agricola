<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Si el usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("Location: ../index.php");
    exit();
}
?>