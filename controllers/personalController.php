<?php

include '../models/personalModel.php';
include_once '../models/globalModel.php';

$accion = $_POST['accion'] ?? null; // Acción a realizar (crearPersonal, etc.)

if($accion == 'crearPersonal'){
    header('Content-Type: application/json'); // Establecer el tipo de contenido a JSON para la respuesta

    // Aquí se procesaría la creación de un nuevo personal utilizando los datos recibidos del formulario
    $idExplotacion = $_POST['idExplotacion'];
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $provinciaId = $_POST['provincia'];
    $municipioId = $_POST['municipio'];
    $nacionalidad = $_POST['nacionalidad'];
    $rol = $_POST['rol'];

    $resultado = guardarPersonal($connection, $idExplotacion, $nombre, $dni, $apellidos, $telefono, $email, $direccion, $provinciaId, $municipioId, $nacionalidad, $rol);
    
    if($resultado){ // Si se ha guardado correctamente, se devuelve una respuesta de éxito
        echo json_encode([
            "ok" => true,
            "mensaje" => "Personal guardado correctamente"
        ]);
    } else { // Si ha habido un error al guardar, se devuelve una respuesta de error
        echo json_encode([
            "ok" => false,
            "mensaje" => "Error al guardar el personal"
        ]); 
    }
}

class PersonalController{
    // Obtener la información del personal para la explotación actual, con idExplotacion = 1 por defecto para pruebas
    static function obtenerInfoPersonal(PDO $connection, int $idExplotacion) {
        $datosPersonal = obtenerPersonal($connection, $idExplotacion);
        $infoPersonal = [];
        foreach ($datosPersonal as $personal) {
            $provincia = obtenerProvincia($connection, $personal['provincia_id']);
            $municipio = obtenerMunicipio($connection, $personal['municipio_id']);
            array_push($infoPersonal, [
                'nombre' => $personal['nombre'] . ' ' .$personal['apellidos'],
                'dni' => $personal['dni'],
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
}

?>