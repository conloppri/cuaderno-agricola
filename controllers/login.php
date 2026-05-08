<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password_hash'])) {
            // Credenciales válidas, redirigir al usuario a la página principal o dashboard
            $_SESSION['username'] = $username;
            header("Location: ../views/explotacionesView.php");
            exit();
        } else {
            // Credenciales inválidas, mostrar un mensaje de error
            echo "Nombre de usuario o contraseña incorrectos.";
        }
}
?>