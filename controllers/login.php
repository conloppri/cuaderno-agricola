<?php
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE id = username");
    $stmt->bindParam('username', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($usuario = $result->fetch_assoc()) {
        if ($result && password_verify($password, $usuario['password_hash'])) {
            // Credenciales válidas, redirigir al usuario a la página principal o dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Credenciales inválidas, mostrar un mensaje de error
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    } else {
        // Usuario no encontrado, mostrar un mensaje de error
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>