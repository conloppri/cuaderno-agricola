<?php

try {
    $connection = new PDO('mysql:host=localhost;dbname=cuadernoDeCampoDB', 'root', '');
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage()); //guardar log de error
    die('Error de conexión a la base de datos.'); //mensaje genérico para el usuario
}
?>