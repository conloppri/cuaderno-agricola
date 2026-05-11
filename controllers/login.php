<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
include "../config/db.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos enviados desde el formulario
    $json = file_get_contents('php://input');

    // Decodificar el JSON para obtener el nombre de usuario y la contraseña
    $data = json_decode($json, true);

    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    // Consultar la base de datos para verificar las credenciales del usuario
    $stmt = $connection->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password_hash'])) {
            // Credenciales válidas. Se envía a JavaScript una respuesta de éxito.
            session_regenerate_id(true);    // Regenerar el ID de sesión para mayor seguridad
            $_SESSION['username'] = $username;
            $_SESSION['usuario_id'] = $result['id'];
            echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso.']);
        } else {
            // Credenciales inválidas. Se envía a JavaScript una respuesta de error.
            echo json_encode(['success' => false, 'message' => 'Nombre de usuario o contraseña incorrectos.']);
        }
}?>