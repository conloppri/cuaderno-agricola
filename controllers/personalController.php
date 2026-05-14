<?php

include '../models/personalModel.php';
include '../models/globalModel.php';

// Obtener la información del personal para la explotación actual, con idExplotacion = 1 por defecto para pruebas
function obtenerInfoPersonal(PDO $connection, int $idExplotacion) {
    $datosPersonal = obtenerPersonal($connection, $idExplotacion);
    $infoPersonal = [];
    foreach ($datosPersonal as $personal) {
        $provincia = obtenerProvincia($connection, $personal['provincia_id']);
        $municipio = obtenerMunicipio($connection, $personal['municipio_id']);
        array_push($infoPersonal, [
            'nombre' => $personal['nombre'] . ' ' .$personal['apellidos'],
            'telefono' => $personal['telefono'],
            'correo_electronico' => $personal['email'],
            'direccion' => $personal['direccion'],
            'provincia' => $provincia,
            'municipio' => $municipio,
            'nacionalidad' => $personal['nacionalidad'],
            'rol' => $personal['rol']
        ]);
    }
    return $infoPersonal;
}

?>